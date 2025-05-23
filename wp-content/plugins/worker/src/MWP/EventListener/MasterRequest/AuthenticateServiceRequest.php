<?php
/*
 * This file is part of the ManageWP Worker plugin.
 *
 * (c) ManageWP LLC <contact@managewp.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class MWP_EventListener_MasterRequest_AuthenticateServiceRequest implements Symfony_EventDispatcher_EventSubscriberInterface
{
    private $configuration;

    private $signer;

    private $signer256;

    private $context;

    function __construct(MWP_Worker_Configuration $configuration, MWP_Signer_Interface $signer, MWP_Signer_Interface $signer256, MWP_WordPress_Context $context)
    {
	    $this->configuration = $configuration;
	    $this->signer        = $signer;
	    $this->signer256     = $signer256;
	    $this->context       = $context;
    }

    public static function getSubscribedEvents()
    {
        return array(
            MWP_Event_Events::MASTER_REQUEST => array('onMasterRequest', 350),
        );
    }

    public function onMasterRequest(MWP_Event_MasterRequest $event)
    {
        $request = $event->getRequest();

        if ($request->isAuthenticated()) {
            return;
        }

        if ($request->getAction() === 'add_site') {
            return;
        }

        $algorithm = $request->getSignatureAlgorithm();

        if ($algorithm == 'SHA256') {
            $serviceSignature = $request->getServiceSignatureV2();
            $noHostSignature  = $request->getNoHostSignatureV2();
        } else {
            $serviceSignature = $request->getServiceSignature();
            $noHostSignature  = $request->getNoHostSignature();
        }

        $keyName = $request->getKeyName();

        if (empty($serviceSignature) || empty($keyName)) {
            $this->context->optionSet('mwp_last_communication_error', 'Unexpected: service signature or key name are empty. Key name: '.$keyName.', Signature: '.$serviceSignature.', Algorithm: '.($algorithm ? $algorithm : 'SHA1'));
            return;
        }

        $publicKey = $this->configuration->getLivePublicKey($keyName);

        if (empty($publicKey)) {
            // for now do not throw an exception, just do not authenticate the request
            // later we should start throwing an exception here when this becomes the main communication method
            $this->context->optionSet('mwp_last_communication_error', 'Could not find the appropriate communication key. Searched for: '.$keyName);
            return;
        }

        $communicationKey = $this->configuration->getCommunicationStringByKeyName($keyName);
        $messageToCheck   = '';

        if (empty($communicationKey)) {
            $this->context->optionSet('mwp_last_communication_error', 'Unexpected: communication key is empty. Key name: '.$keyName);
            return;
        }

        if (empty($noHostSignature)) {
            $messageToCheck = $request->server['HTTP_HOST'];
        }

        $messageToCheck .= $communicationKey.$request->getAction().$request->getNonce().json_encode($request->getParams());

        if (empty($messageToCheck)) {
            // for now do not throw an exception, just do not authenticate the request
            // later we should start throwing an exception here when this becomes the main communication method
            $this->context->optionSet('mwp_last_communication_error', 'Unexpected: message to check is empty. Host: '.$request->server['HTTP_HOST']);
            return;
        }

	    if ($algorithm == 'SHA256') {
		    $verify = $this->signer256->verify($messageToCheck, !empty($noHostSignature) ? $noHostSignature : $serviceSignature, $publicKey, $algorithm);
	    } else {
		    $verify = $this->signer->verify($messageToCheck, !empty($noHostSignature) ? $noHostSignature : $serviceSignature, $publicKey, $algorithm);
	    }

        if (!$verify) {
            // for now do not throw an exception, just do not authenticate the request
            // later we should start throwing an exception here when this becomes the main communication method
            $this->context->optionSet('mwp_last_communication_error', 'Message signature invalid. Tried to verify: '.$messageToCheck.', Signature: '.base64_encode($serviceSignature));
            return;
        }

        $request->setAuthenticated(true);
        $this->context->optionSet('mwp_new_communication_established', true);
        $this->configuration->acceptCommunicationKeyIfEmpty($keyName, $communicationKey);
    }
}
