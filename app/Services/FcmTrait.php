<?php

namespace App\Services;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use App\User;
use App\FcmUser;

trait FcmTrait {
    
    /**
     * Undocumented function
     *
     * @param User $user
     * @param [type] $data
     * @return void
     */
    private function sendFcm(User $user, $data)
    {
        $optionBuiler = new OptionsBuilder();
		$optionBuiler->setTimeToLive(60 * 20);
        $option = $optionBuiler->build();
        
        $notificationBuilder_ar = new PayloadNotificationBuilder($data['ar']['title']);
		$notificationBuilder_ar->setBody($data['ar']['body']);
		$notificationBuilder_ar->setSound( 'default' );

		$notificationBuilder_en = new PayloadNotificationBuilder($data['en']['title']);
		$notificationBuilder_en->setBody($data['en']['body']);
        $notificationBuilder_en->setSound('default');
        
        $dataBuilder_ar = new PayloadDataBuilder();
        $dataBuilder_en = new PayloadDataBuilder();
        
        $info = [];

		$info['ar'] = [
			'title' => $data['ar']['title'],
			'body' => $data['ar']['body'],
        ];
        
		$info['en'] = [
			'title' => $data['en']['title'],
			'body' => $data['en']['body'],
        ];
        
        $dataBuilder_ar->addData($info['ar']);
		$dataBuilder_en->addData($info['en']);

		$notification_ar = $notificationBuilder_ar->build();
		$notification_en = $notificationBuilder_en->build();

		$data_ar = $dataBuilder_ar->build();
        $data_en = $dataBuilder_en->build();
        
        //all android tokens
        $android_tokens_ar = (isset($user->devices)) ? $user->devices()->android()->lang('ar')->pluck('token')->toArray(): [];
        $android_tokens_en = (isset($user->devices)) ? $user->devices()->android()->lang('en')->pluck('token')->toArray() : [];
    
        //all ios tokens
        $ios_tokens_ar = (isset($user->devices)) ? $user->devices()->ios()->lang('ar')->pluck('token')->toArray(): [];
        $ios_tokens_en = (isset($user->devices))? $user->devices()->ios()->lang('en')->pluck('token')->toArray() :[];

        $notification = [
			'action' => __CLASS__ . '@send',
			'options' => $data,
			'android' => [
				'ar' => [
					'tokens' => $android_tokens_ar,
				],
				'en' => [
					'tokens' => $android_tokens_en,
				],
			],			
			'ios' => [
				'ar' => [
					'tokens' => $ios_tokens_ar,
				],
				'en' => [
					'tokens' => $ios_tokens_en,
				],
			],
		];

        /**
         * Sending
         */

        if( count($android_tokens_ar) > 0 ){
			$andResponse = FCM::sendTo($android_tokens_ar, $option, null, $data_ar);
			$and_tok_del = $andResponse->tokensToDelete();
			FcmUser::deleteTokens($and_tok_del);
			$and_tok_mod = $andResponse->tokensToModify();
			$and_tok_ret = $andResponse->tokensToRetry();
			$and_tok_err = $andResponse->tokensWithError();
			FcmUser::deleteTokens($and_tok_err);
		}

		if( count($android_tokens_en) > 0 ){
			$andResponse = FCM::sendTo($android_tokens_en, $option, null, $data_en);
			$and_tok_del = $andResponse->tokensToDelete();
			FcmUser::deleteTokens($and_tok_del);
			$and_tok_mod = $andResponse->tokensToModify();
			$and_tok_ret = $andResponse->tokensToRetry();
			$and_tok_err = $andResponse->tokensWithError();
			FcmUser::deleteTokens($and_tok_err);
        }
        
		if( count($ios_tokens_ar) > 0 ){
			$iosResponse = FCM::sendTo($ios_tokens_ar, $option, $notification_ar, $data_ar);
			$ios_tok_del = $iosResponse->tokensToDelete();
			FcmUser::deleteTokens($ios_tok_del);
			$ios_tok_mod = $iosResponse->tokensToModify();
			$ios_tok_ret = $iosResponse->tokensToRetry();
			$ios_tok_err = $iosResponse->tokensWithError();
			FcmUser::deleteTokens($ios_tok_err);
		}

		if( count($ios_tokens_en) > 0 ){
			$iosResponse = FCM::sendTo($ios_tokens_en, $option, $notification_en, $data_en);
			$ios_tok_del = $iosResponse->tokensToDelete();
			FcmUser::deleteTokens($ios_tok_del);
			$ios_tok_mod = $iosResponse->tokensToModify();
			$ios_tok_ret = $iosResponse->tokensToRetry();
			$ios_tok_err = $iosResponse->tokensWithError();
			FcmUser::deleteTokens($ios_tok_err);
		}

		\Log::info($notification);
		return $notification;
    }
}