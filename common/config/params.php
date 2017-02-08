<?php
return [
    'adminEmail' => 'kandepohetest@gmail.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'pageError' => 'Sorry but there was an error: ',
    'sendInterestMessage' => '#NAME#  interested in your profile.',
    'phoneNumberSeeMessage' => '#NAME# viewed your phone number.',
    'modalTitle' => 'Confirmation',
    'acceptRequest' => 'Are You sure want to Accept Request ?',
    'declineRequest' => 'Are You sure want to Reject Request ?',
    'requestAccepted' => '#NAME# is accepted your request.',
    'searchingLimit' => 3,
    'noRecordsFoundInSearchList' => 'There are no record found as per your searching criteria.',
    'loginFirst' => 'For this you have to login first...!',
    'accessDenied' => 'Access Denied',
    'accessDeniedYourProfile' => "You can't see your profile as user view.",
    'accessDeniedInvalid' => "Trying to access invalid data.",
    'sendInterest' => " Do You want to Send Interest Request ?",
    'acceptInterest' => " Do You want to Accept Interest ?",
    'declineInterest' => " Do You want to Decline Interest ?",
    'cancelInterest' => " Do You want to Cancel Interest ?",
    'acceptInterestMessage' => '#NAME#  has accepted interest request.',
    'declineInterestMessage' => '#NAME#  has Decline interest request.',
    'cancelInterestMessage' => '#NAME#  has Cancel their interest request.',
    'moreConversationErrorMessage' => 'Conversation no longer available,',
    'sendInterestMessageInbox' => 'Would you like to communicate further ?',
    'mailBoxSendInterestSender' => 'You sent #GENDER# interest request.',
    'mailBoxSendInterestReceiver' => '#GENDER# sent you interest request.',
    'smsGetwayError' => 'Something wrong with SMS sending Process. Please contact to site admin.',
    'photoMissingError' => 'Photo has issue. Please try again !',
    'photoCopyError' => 'Photo saving has issue. Please try again !',
    'photoCropAreaSelection' => 'Please first select photo portion !',



    'noRecordsFoundInShortList' => 'There are no record found in your short list.',


    'titleInformation' => 'Information',
    'titleWarrning' => 'Warrning',

    'resetPasswordWrongEmailIdMessage' => 'This email ID is not registered at Kande-Pohe.com. Please contact administrator to reset your password',
    'ref' => ['recently_joined' => 'recently_joined', 'you_shortlisted_by' => 'you_shortlisted_by'],
    'pageArray' => [1 => 'site/basic-details', 2 => 'site/education-occupation', 3 => 'site/life-style', 4 => 'site/about-family', 5 => 'site/about-yourself', 6 => 'user/photos', 7 => 'site/verification'],
    'searchListInCorrectErrorMessage' => 'You are trying to access invalid URL.',
    'firstPhotoPagePopup' => '<strong><h3 class="text-success">Congratulations!</h3> <br>Your profile has been created.</strong><br><br> Now upload photos and get more visitors to your profile.',
    'messageCommunitieBS' => 'To include more communities, please use Advance Search.',
    'messageSubCommunitieBS' => 'To include more sub communities, please use Advance Search.',
    'messageReligionBS' => 'To include more Religion, please use Advance Search.',
    'messageJsCall' => 'Something went wrong. Please try again !',
    'errorMessage' => 'Something went wrong. Please try again !',

    /* Photo Section Start */
    'sizeUserPhoto' => array(30, 63, 75, 110, 120, 155, 180, 200, 260),
    'cropSize' => 200,
    'timePinValidate' => 15,
    'total_files_allowed' => 12,
    'max_file_size' => 104857600, // 100 MB (1 MB = 1048576 Bytes)
    'maxWidth' => 500,
    'thumbnailPrefix' => 'thumb_',
    'profilePrefix' => '_profile_',
    'allowed_file_types' => "'image/png', 'image/gif', 'image/jpeg', 'image/pjpeg'",
    'profilePhotoFolder' => 'profile',
    'noPhotoAvailable' => 'No Photos Available',
    'cover' => 'COVER',
    'photoSetAsCover' => 'Click for select Photo as Cover Photo',
    'photoSetAsProfile' => 'Click for select Photo as Profile Photo',
    'photoDisapproveMessage' => 'Please Remove this Photo',
    'photoPendingMessage' => 'Awaiting Approval',

    'uploadPhotoListWait' => 'Uploading Photos... Please Wait !',
    'uploadPhotoLimit' => 5, // At a time user can upload maximum 5 photos
    'uploadLimitError' => 'You can not upload photos more than total upload photo limit.<br> Your remaining photo upload limit is : #LIMIT#',
    'photoPendingMode' => 'Please Wait ! Photos will be screened and make live within 4-6 hours.',
    'photoApprovedMode' => 'Photo has been Approved.',
    'photoDisapprovedMode' => 'Photo is not appropriate as per our policy and is not available on portal. We Request you to upload another photo.', //Irrelevant photo
    'browserFileSupportError' => 'Your browser does not support new File API! Please upgrade.',
    'fileUploadSize' => 'You are trying to upload photos more than limit.',
    'fileUnsoupportedType' => 'You are trying to upload unsupported file type.',
    'coverPhotoSetConfirmation' => 'Are you sure want to set this photo as cover photo?',
    /* Photo Section End */
    'smokeArray' => ['Yes' => 'Smoke_Yes', 'No' => 'Smoke_No', 'Occasionally' => 'Smoke_Occasionally'],
    'drinkArray' => ['Yes' => 'Drink_Yes', 'No' => 'Drink_No', 'Occasionally' => 'Drink_Occasionally'],
    'eyesArray' => ['Spectacles' => 'SpectaclesLens_Spectacles', 'Lens' => 'SpectaclesLens_Lens'],
    'deleteProfileTitle' => 'Delete profile',
    'deleteProfileMessage' => 'Are you sure you want to delete your profile?',
    'deleteProfileNote' => 'Deleting your account will disable your Profile. Some information may still be visible to others,
                        such as your name in their Inbox list and messages that you\'ve sent.',
    'validationDone' => 'VERIFICATION-DONE',
    'multipleProfileMsg' => 'Multiple Profile',
    'multipleProfile' => 'It appears that the number you verified is associated with another profile',
    'MultipleProfileTellUp' => 'Tell us why you wish to have multiple profiles with the same number. How are you related to these profiles ?',
    'MultipleProfileContact' => '(Please note sandepohe.com team may contact you in this regard)',
    'multipleProfileOption' => [
        'Keep this profile, delete others' => '1',
        'Provide alternate no. for this profile' => '2',
        'Will use old profile, delete this one' => '3',
        'I wish to have multiple profiles' => '4'
    ],
    # Privacy Setting Start
    'privacyPhone' => [
        'Visible to all Premium Members' => '1',
        'Visible to Premium Members you wish to connect with' => '2',
        'Not visible to anyone' => '3'
    ],
    'privacyPhoto' => [
        'Visible to all' => '1',
        'Visible only on invitation Sent/Accepted' => '2',
    ],
    'privacyVisitor' => [
        'Let other members know that I have visited their profile' => '1',
        'Do not let other members know that I have visited their profile' => '2',
    ],
    # Privacy Setting End

    'familyTypeArray' => ['Joint' => 'Family_Joint', 'Nuclear' => 'Family_Nuclear'],
];

