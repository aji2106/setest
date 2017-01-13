<?php
  set_time_limit(0);

  $marketsList=[];
  $marketsList['AT']='de_AT';
  $marketsList['AU']='en_AU';
  $marketsList['BE']='fr_BE';
  $marketsList['BR']='pt_BR';
  $marketsList['CA']='en_CA';
  $marketsList['CL']='es_CL';
  $marketsList['CO']='es_CO';
  $marketsList['CZ']='cz_CZ';
  $marketsList['DE']='de_DE';
  $marketsList['DK']='da_DK';
  $marketsList['ES']='es_ES';
  $marketsList['FI']='fi_FI';
  $marketsList['FR']='fr_FR';
  $marketsList['IE']='id_ID';
  $marketsList['IT']='it_IT';
  $marketsList['MX']='es_MX';
  $marketsList['NL']='nl_NL';
  $marketsList['NZ']='en_NZ';
  $marketsList['PL']='pl_PL';
  $marketsList['RU']='ru_RU';
  $marketsList['SE']='sv_SE';
  $marketsList['SK']='sk_SK';
  $marketsList['GB']='en_GB';
  $marketsList['US']='en_US';
  $marketsList['PT']='en_PT';

  $marketDomainList=[];
  $marketDomainList["AT"]="adidas.at";
  $marketDomainList["AU"]="adidas.com.au";
  $marketDomainList["BE"]="adidas.be";
  $marketDomainList["BR"]="adidas.com.br";
  $marketDomainList["CA"]="adidas.ca";
  $marketDomainList["CL"]="adidas.cl";
  $marketDomainList["CO"]="adidas.co";
  $marketDomainList["CZ"]="adidas.cz";
  $marketDomainList["DE"]="adidas.de";
  $marketDomainList["DK"]="adidas.dk";
  $marketDomainList["ES"]="adidas.es";
  $marketDomainList["FI"]="adidas.fi";
  $marketDomainList["FR"]="adidas.fr";
  $marketDomainList["IE"]="adidas.ie";
  $marketDomainList["IT"]="adidas.it";
  $marketDomainList["MX"]="adidas.mx";
  $marketDomainList["NL"]="adidas.nl";
  $marketDomainList["NZ"]="adidas.co.nz";
  $marketDomainList["PL"]="adidas.pl";
  $marketDomainList["RU"]="adidas.ru";
  $marketDomainList["SE"]="adidas.se";
  $marketDomainList["SK"]="adidas.sk";
  $marketDomainList["GB"]="adidas.co.uk";
  $marketDomainList["US"]="adidas.com";
  $marketDomainList["PT"]="adidas.com";

?>
<?php if ( (isset($_POST['atcPostContinueShopping'])) && (strlen($_POST['atcPostContinueShopping'])>0) ): ?>  <!-- Process ATC via Continue Shopping -->
<?php
  //Parse POST parameters
  $pid=$_POST['pid'];
  $masterPid=$_POST['masterPid'];
  $gcaptcha=$_POST['gcaptcha'];
  $clientId=$_POST['clientId'];
  $locale=$_POST['locale'];
  $duplicate=$_POST['duplicate'];

  $baseJSResourceUrl="http://www.adidas.com";
  $baseRestoreBasketUrl="http://www.".$marketDomainList[$locale];
  if ($locale == "PT")
  {
    $baseADCURL="http://www.".$marketDomainList[$locale]."/on/demandware.store/Sites-adidas-"."MLT"."-Site/".$marketsList[$locale];
  }
  else
  {
    $baseADCURL="http://www.".$marketDomainList[$locale]."/on/demandware.store/Sites-adidas-".$locale."-Site/".$marketsList[$locale];
  }
  $atcURL=$baseADCURL."/Cart-MiniAddProduct";
  $cartShowURL=$baseADCURL."/Cart-Show";

  if ((strlen($gcaptcha)>1))
  {
    $backDoorADCURL1=$atcURL."?pid=".$pid."&masterPid=".$masterPid."&ajax=true&g-recaptcha-response=".$gcaptcha."&x-PrdRt=".$gcaptcha;
    $backDoorADCURL2=$atcURL."?pid=".$pid."&masterPid=".$masterPid."&ajax=true&g-recaptcha-response=".$gcaptcha;
  }
  else
  {
    $backDoorADCURL=$atcURL."?pid=".$pid."&masterPid=".$masterPid."&ajax=true";
  }

  $response=<<<EOT
<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="en-US" http-equiv="Content-Language">
    <meta content="on" http-equiv="x-dns-prefetch-control">
    <link href="//demandware.edgesuite.net" rel="dns-prefetch">
    <link href="//hp.static.adidas.com" rel="dns-prefetch">
    <link href="//tags.tiqcdn.com" rel="dns-prefetch">
    <link href="//cdn.optimizely.com" rel="dns-prefetch">
    <link href="//adidas.ugc.bazaarvoice.com" rel="dns-prefetch">
    <link href="//maps.googleapis.com" rel="dns-prefetch">
    <meta content="website" property="og:type">
    <meta content="adidas United States" property="og:site_name">
    <meta content="100002410377144" property="fb:admins">
    <meta content="https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Cart-Show" property="og:url">
    <title>adidas Official Website | adidas</title><!--[if lte IE 8]>
<script type="text/javascript">
  document.createElement('segment');
</script>
<![endif]-->
    <!-- build page type:cart -->
    <link href="https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/en_US/v1473925034493/css/fonts.css" rel="stylesheet" type="text/css"><!-- cart -->
    <link href="https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/en_US/v1473925034493/css/adidas-build-COMMON.css" rel="stylesheet" type="text/css">
    <link href="https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/en_US/v1473925034493/css/adidas-build-cart.css" rel="stylesheet" type="text/css"><!--[if lt IE 10]>
<link href="https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/en_US/v1473925034493/css/adidas-build-COMMON-iefix.css" type="text/css" rel="stylesheet" />
<![endif]-->
    <link href="https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/en_US/v1473925034493/css/local.css" rel="stylesheet" type="text/css"><!--[if IE 8]><link href="https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/en_US/v1473925034493/css/ie8_global.css" type="text/css" rel="stylesheet" /><![endif]-->
    <!--[if IE 9]><link href="https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/en_US/v1473925034493/css/ie9_global.css" type="text/css" rel="stylesheet" /><![endif]-->
    <link href="https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/default/dw31ad4eff/images/favicon.ico" rel="icon" type="image/x-icon">
    <link href="https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/default/dw31ad4eff/images/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/default/dwc3cad1ba/images/apple-touch-icon-precomposed.png" rel="apple-touch-icon-precomposed">
    <link href="https://plus.google.com/101842039723189178420" rel="publisher">
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta content="noindex, follow" name="robots">
    <meta content="129087217170262" property="fb:app_id">
    <meta content="telephone=no" name="format-detection"><!--[if lte IE 8]>
<script src="https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/en_US/v1473925034493/js/iefix.js" type="text/javascript"></script>
<script src="https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/en_US/v1473925034493/js/json2.min.js" type="text/javascript"></script>
<![endif]-->

    <script src="https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/en_US/v1473925034493/js/vendor/require.js" type="text/javascript">
    </script>
    <script src="https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/en_US/v1473925034493/js/vendor/jquery-1.8.3.min.js" type="text/javascript">
    </script>
    <script type="text/javascript">
    jQuery.curCSS = jQuery.css;
    </script><!--[if lte IE 9]>
<script src="https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/en_US/v1473925034493/js/jquery.placeholder.js" type="text/javascript"></script>
<script type="text/javascript">jQuery(function () { try { jQuery('input, textarea').placeholder(); } catch(e) {} });</script>
<![endif]-->
    <!-- cart -->

    <script type="text/javascript">
    window.app=jQuery.extend(window.app || {}, {isBuilded:true,bundlesRequired:
    ["https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/en_US/v1473925034493/js/adidas-build-COMMON.js"

    ,"https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/en_US/v1473925034493/js/adidas-build-cart.js"

    ]});
    </script>
    <script src="https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/en_US/v1473925034493/js/vendor/web-event.js" type="text/javascript">
    </script>
    <script type="text/javascript">





    (function () {
    'use strict';
    app.constants = {};
    app.resources = {};
    app.minicart = {};
    app.URLs = {};
    app.minicart.oldLayerToNew = (function (map) {
    return function (layer, defaultValue) {
    return map[layer] || defaultValue;
    };
    }({
    "minicart": "Mini cart",
    "overlay": "Add To Bag overlay",
    "straightcart": "Straight to Cart"
    }));
    app.isMobile = false;
    app.isAdidas = true;
    app.isReebok = false;
    app.isCrossfit = false;
    app.isBrooklynNets = false;
    app.minicart.url = "/on/demandware.store/Sites-adidas-US-Site/en_US/Cart-MiniAddProduct";
    app.minicart.show = "/on/demandware.store/Sites-adidas-US-Site/en_US/Cart-MiniCart";
    app.minicart.productCountUrl = "/on/demandware.store/Sites-adidas-US-Site/en_US/Cart-ProductCount";
    app.URLs.personalizedBasketCheck = "/on/demandware.store/Sites-adidas-US-Site/en_US/Cart-ValidatePersonalizationBasket";
    app.URLs.deliveryStart = "/us/delivery-start";
    app.URLs.getFullProductUrl = "https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Product-Show";
    app.URLs.getProductUrl = "/on/demandware.store/Sites-adidas-US-Site/en_US/Product-Show";
    app.URLs.getVariants = "/on/demandware.store/Sites-adidas-US-Site/en_US/Product-GetVariants";
    app.URLs.getMasterAvailability = "/on/demandware.store/Sites-adidas-US-Site/en_US/Product-GetMasterAvailability";
    app.URLs.getAvailability = "/on/demandware.store/Sites-adidas-US-Site/en_US/Product-GetAvailability";
    app.URLs.loadingSmallImg = "/on/demandware.static/Sites-adidas-US-Site/-/default/dwba17e999/images/loading-small.gif";
    app.URLs.formatMoney = "/on/demandware.store/Sites-adidas-US-Site/en_US/Product-FormatPrices";
    app.URLs.removeImg = "/on/demandware.static/Sites-adidas-US-Site/-/default/dwc8e53f09/images/icon_remove.gif";
    app.URLs.getProductTileList = "/on/demandware.store/Sites-adidas-US-Site/en_US/Product-GetTiles";
    app.URLs.getAssetContent = "/on/demandware.store/Sites-adidas-US-Site/en_US/Page-Include";
    app.URLs.jsonConfiguratorLink = "http://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Configurator-GetJsonURL";
    app.URLs.sendToFriend = "http://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/SendToFriend-Start";
    app.URLs.blankImg = "/on/demandware.static/Sites-adidas-US-Site/-/default/dw56d45f8a/images/blank.gif";
    app.URLs.showImage = "http://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Product-ShowImage";
    app.URLs.searchSuggestURL = "/on/demandware.store/Sites-adidas-US-Site/en_US/Search-GetSuggestions";
    app.URLs.viewAllSuggestURL = "/us/search";
    app.URLs.cartSummaryBlock = "https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Cart-GetCartSummaryBlock";
    app.URLs.pageHeaderInfo = "https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Page-HeaderInfo";
    app.URLs.includeHeaderCustomerInfo = "https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Home-IncludeHeaderCustomerInfo";
    app.URLs.accountShow = "https://www.adidas.com/us/myaccount";
    app.URLs.loginLogout = "https://www.adidas.com/us/login-logout";
    app.URLs.deliverySubmits = "https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/CODelivery-Submits";
    app.URLs.deliveryCnC = "https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/OmniChannel-ShowOnDelivery";
    app.URLs.showCartURL = "https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Cart-Show";
    app.URLs.lookupEmail = "https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/CODelivery-LookupEmail";
    app.URLs.paymentPage = "https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/COSummary-Start";
    app.URLs.SLPBazaarVoice = "http://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Search-SLPBazaarVoice";
    app.URLs.linkPlayerSkin = "https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/default/dwfee10d06/images/jwplayer/AdiSkin.xml";
    app.URLs.linkFlashPlayer = "https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/default/dw282d287b/images/jwplayer/player-licensed.swf";
    app.URLs.loginValidationURL = "/on/demandware.store/Sites-adidas-US-Site/en_US/ShopRunner-ValidateToken";
    app.URLs.getShipmentMethods = "https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/CODelivery-GetShippingOptions";
    app.URLs.storeSelectedPostamat = "https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Helpers-StoreValueInSession";
    app.URLs.savePostNumberID = "/on/demandware.store/Sites-adidas-US-Site/en_US/OmniChannel-setPostNumberId";
    app.URLs.fillInScheduledDelivery = "/on/demandware.store/Sites-adidas-US-Site/en_US/CODelivery-FillInScheduledDelivery";
    app.URLs.getAddressTemplate = "/on/demandware.store/Sites-adidas-US-Site/en_US/CODelivery-GetAddressTemplate";
    app.URLs.getEPOCHAvailability = "/on/demandware.store/Sites-adidas-US-Site/en_US/OmniChannel-GetEPOCHAvailability";
    app.URLs.getUspBar = "/on/demandware.store/Sites-adidas-US-Site/en_US/Page-GetUSPBar";
    app.URLs.setSubscriptionFlagUrl = "https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/COPayment2-SetNewsletterFlag";
    app.URLs.productComparisonPage = "/on/demandware.store/Sites-adidas-US-Site/en_US/Product-Comparison";
    app.URLs.createComingSoonSignup = "/on/demandware.store/Sites-adidas-US-Site/en_US/SCV-CreateCommingSoonSignup";
    app.URLs.PERSONALIZATION_BASE_URL = "http://cfg.adidas.com";
    app.URLs.PERSONALIZATION = {
    ppr: "/configurator/services/miadidas-configurator/ppdo/article/{article}/region/{region}/channel/{channel}/partner/{partner}",
    rr: "/configurator/services/miadidas-configurator/pRecipeService/recipeIdent/{recipeIdent}/region/{region}/channel/{channel}/partner/{partner}",
    plr: "/configurator/services/miadidas-configurator/sldProfanity/productTypeId/{productType}/specialType/Personalization/region/{region}/channel/{channel}/partner/{partner}",
    ic: "/configurator/services/miadidas-configurator/pRecipeService/validateinventory/deductInventory/{deductInventory}/region/{region}/channel/{channel}/partner/{partner}"
    };
    app.URLs.getBVReviews = "/on/demandware.store/Sites-adidas-US-Site/en_US/Product-GetBVReview";
    app.URLs.HelpSuggest = "https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Help-Suggest?q=";
    // Preferences
    app.CommissionJunctionEnable = false;
    app.noneCom = false;
    app.shoprunnerEnabled = true;
    app.epochShipFromStoreEnabled = false;
    app.shoprunnerRetailerID = "ADIDAS";
    app.shoprunnerEnvironmentID = "2";
    app.minimumInstallmentAmount = "null";
    app.contentURL = "";

    /*constants*/
    app.constants.AVAIL_STATUS_IN_STOCK="IN_STOCK";
    app.constants.AVAIL_STATUS_PREORDER="PREORDER";
    app.constants.AVAIL_STATUS_BACKORDER="BACKORDER";
    app.constants.AVAIL_STATUS_NOT_AVAILABLE="NOT_AVAILABLE";
    app.constants.AVAIL_STATUS_PREVIEW="PREVIEW";
    app.constants.LOCALE="en_US";
    app.constants.SITE_ID="adidas-US";
    app.constants.LAZY_LOAD_SPACE="400";
    app.constants.PRODUCT_MAX_QTY_THRESHOLD="5";
    app.constants.GENERIC_MAX_QTY_THRESHOLD="0";
    app.constants.CURRENCY_CODE = "USD";
    app.constants.HIDE_SHIPPING_METHODS_ON_CART = true;
    app.constants.ADDRESS_VALIDATION_PROVIDER = "Avatax";
    app.constants.ADDRESS_DOCTOR_IMPROVEMENT = "false";
    app.constants.ADDRESS_DOCTOR_POPUP_TITLE = "Verify your address";
    app.constants.USE_SPLITTED_DELIVERY = false;
    app.constants.PERSONALIZATION_CHANNEL = "1";
    app.constants.PERSONALIZATION_PARTNER = "null";
    /*resources*/
    app.resources["LIMIT_QUANTITY"]="Limited to {0} item(s) per purchase";
    app.resources["MISSINGVAL"]="Please Enter {0}";
    app.resources["SERVER_ERROR"]="Server connection failed!";
    app.resources["MISSING_LIB"]="jQuery is undefined.";
    app.resources["MISSING_APP_LIB"]="app is undefined.";
    app.resources["BAD_RESPONSE"]="Bad response, Parser error";
    app.resources["INVALID_PHONE"]="Please specify a valid phone number.";
    app.resources["REMOVE"]="Remove";
    app.resources["QTY"]="Quantity";
    app.resources["SEARCH_TEXT"]="Search";
    app.resources["NOHITS_SEARCH_TEXT"]="Search";
    app.resources["PRICE_EXAMPLE"] = '$1,234.00';
    app.resources["SHIPPINGCOSTFREE"] = "FREE";
    app.resources["NO_REVIEWS"]="There are no reviews for this product";
    app.resources["STICKVOGEL_POPUP_TITLE"]="stickvogel.popuptitle";
    app.resources["MOBILE_COOKIE_EXPIRATION_DATE"] = "null";
    app.resources["DEV_INSTANCE_WARNING"] = "This is NOT A LIVE SITE. This is test environment. Do NOT place orders.";
    app.resources["LOGIN_LOGOUT_TEXT"] = "Logout";
    app.resources["SIZE_LABEL"] = "Size";
    app.resources["ZOOM_TYPE"] = "default";
    app.resources["ZOOM_MESSAGE"] = "LOADING";
    app.resources["CURSOR_URL_IMAGE"] = "/on/demandware.static/Sites-adidas-US-Site/-/default/dwe3e7d33c/images/cursor-zoomed-circle.cur";
    app.resources["GLOBAL_UPDATE"] = "Update";
    app.resources["GLOBAL_LOADING"] = "Loading";
    app.resources["GLOBAL_CONFIRM_UPDATE"] = "Confirm your update";
    app.resources["CLICKCOLLECT_UNAVAILABLE_TITLE_MESSAGE"] = "Because of an update to your bag, click & collect is no longer available and delivery times have changed.";
    app.resources["CLICKCOLLECT_UNAVAILABLE_MESSAGE"] = "Please select one of the updated delivery options and time-slots below.";
    app.resources["CLICKCOLLECT_AVAILABLE_TITLE_MESSAGE"] = "Because of an update to your bag, click & collect and new delivery times and are now available.";
    app.resources["CLICKCOLLECT_AVAILABLE_MESSAGE"] = "Please select one of the updated delivery options and time-slots below.";
    app.resources["MINICART_CLICKCOLLECT_UNAVAILABLE"] = "With this update to your bag, click & collect is now available and your delivery times will change. You will be taken back to the delivery page.";
    app.resources["MINICART_CLICKCOLLECT_AVAILABLE"] = "With this update to your bag, click & collect will no longer be available and your delivery times will change. You will be taken back to the delivery page.";
    app.resources["CLICKCOLLECT_SCHEDULED_DELIVERY_UNAVAILABLE_TITLE_MESSAGE"] = "Because of an update to your bag, click & collect and sechulded delivery are no longer available and delivery times have changed.";
    app.resources["CLICKCOLLECT_SCHEDULED_DELIVERY_UNAVAILABLE_MESSAGE"] = "Please select one of the updated delivery options and time-slots below.";
    app.resources["CLICKCOLLECT_SCHEDULED_DELIVERY_AVAILABLE_TITLE_MESSAGE"] = "Because of an update to your bag, click & collect, scheduled delivery and new delivery times  are now available.";
    app.resources["CLICKCOLLECT_SCHEDULED_DELIVERY_AVAILABLE_MESSAGE"] = "Please select one of the updated delivery options and time-slots below.";
    app.resources["CLICKCOLLECT_AVAILABLE_TIMEINTERVAL_TITLE_MESSAGE"] = "Because you updated your bag, new delivery times are now available.";
    app.resources["CLICKCOLLECT_AVAILABLE_TIMEINTERVAL_MESSAGE"] = "Please select one of the updated delivery time-slots";
    app.resources["MINICART_TIMEINTERVAL"] = "With this update, your delivery times will change. You will be taken back to the delivery page.";
    app.resources["MINICART_CLICKCOLLECT_SCHEDULED_DELIVERY_UNAVAILABLE"] = "With this update to your bag, click & collect and scheduled delivery will no longer be available and your delivery times will change . You will taken back to the delivery page.";
    app.resources["MINICART_CLICKCOLLECT_SCHEDULED_DELIVERY_AVAILABLE"] = "With this update to your bag, click & collect and scheduled delivery are now available and your delivery times will change. You will be  taken back to the delivery page.";
    app.resources["PROCESSING_PAYMENT"] = "Processing payment";
    app.resources["IMAGE_LOADING"] = "Loading image";
    app.resources.PERSONALIZATION_TEXTS = {
    'nameAndNumber': "Add name & number",
    'pName-pNumber.nameAndNumber.textwithDropDown': "Select Player",
    'pName-pNumber.nameAndNumber': "Choose your own",
    'pName-pNumber.nameOfnameAndNumber': "Name",
    'pName-pNumber.numberOfnameAndNumber': "00",
    'pNumber.nameAndNumber.textNumber': "Text",
    'pName-pName-pNumber.nameAndNumber.textwithDropDown': "Select Player",
    'pName-pName-pNumber.nameAndNumber': "Choose your own",
    'pName-pName-pNumber.nameOfnameAndNumber': "personalization.pName-pName-pNumber.nameOfnameAndNumber.displayText",
    'pName-pName-pNumber.numberOfnameAndNumber': "personalization.pName-pName-pNumber.numberOfnameAndNumber.displayText",
    'pName-pName-pNumber.nameOnly': "personalization.pName-pName-pNumber.nameOnly.displayText",
    'left_text.text': "Left shoe (A-Z, 0-9)",
    'right_text.text': "Right shoe (A-Z, 0-9)"
    };
    /* postal code lookup*/
    app.resources["ENABLE_POSTAL_CODE_LOOKUP"] = false;
    app.resources["POSTAL_CODE_LOOKUP_MANUAL"] = false;
    app.resources["POSTAL_CODE_LOOKUP_BILLING_MANUAL"] = null;
    app.resources["CODELIVERY_POSTAL_CODE_LOOKUP_MANUAL"] = "/on/demandware.store/Sites-adidas-US-Site/en_US/CODelivery-PostalCodeLookUpManual";
    app.resources["POSTAL_LOADING"] = "Loading...";
    app.resources["POSTAL_FINDADDRESS"] = "Find Address";
    app.resources["POSTAL_NO_ADDRESS_SUGGESTION"] = "Adderess not found? <span class='postal-enter-manually'>Enter manually<\/span>";
    app.resources["POSTAL_NO_ADDRESS_SUGGESTION_MOBILE"] = "Adderess not found? Enter manually";
    app.resources["SELECT_YOUR_ADDRESS"] = "Select your address";
    app.resources["EDIT_YOUR_ADDRESS"] = "Edit Address";
    app.resources["POSTAL_LOADING_ERROR_SELECT_ADDRESS"] = "Please choose your address";
    app.resources["ADDRESS_SUGGESTION_FAIL_SERVICE"] = "We are sorry, validation service is unavailable right now";
    /*product availability messages*/
    app.resources["IN_STOCK"]="In Stock";
    app.resources["QTY_IN_STOCK"]="{0} Item(s) In Stock";
    app.resources["PREORDER"]="<span style=\"color:green;font-weight:bold;\">PRE-ORDER NOW!<\/span> Only {0} days left to Pre-order";
    app.resources["QTY_PREORDER"]="{0} item(s) are available for Pre-order.";
    app.resources["REMAIN_PREORDER"]="The remaining items are available for Pre-order.";
    app.resources["BACKORDER"]="Back Order";
    app.resources["QTY_BACKORDER"]="Back Order {0} item(s)";
    app.resources["REMAIN_BACKORDER"]="The remaining items are available on back order.";
    app.resources["NOT_AVAILABLE"]="This item is currently not available.";
    app.resources["REMAIN_NOT_AVAILABLE"]="The remaining items are currently not available. Please adjust the quantity.";
    app.resources["IN_STOCK_DATE"]="The expected in-stock date is {0}.";
    app.resources["NON_SELECTED"]="Not Selected";
    app.resources["MISSING_VAL"]="Select {0}";
    app.resources["SIZECHART_TITLE"]="Size Chart";
    app.resources["SEND_TO_FRIEND"]="Send to a Friend";
    app.resources["QTY_LIMIT_MESSAGE"]="Only {0} left in stock";
    app.resources["LOW_LIMIT_MESSAGE"]="Low in stock";
    /*add resources for preview*/
    app.resources["PREVIEW"]="<span class=\"callout-bar-headline\">COMING SOON!<\/span><span class=\"callout-bar-short\"><span class=\"callout-bar-text\">Available in <\/span><span class=\"callout-bar-day-count\">{0} day(s)<\/span><\/span>";
    app.resources["ADD_TO_CART_COMING_SOON"]="Coming Soon";
    app.resources["ADD_TO_CART_PREORDER"]="Pre-order now";
    /*Comparison*/
    app.resources["COMPARE_SINGLE"] ="{0}/{1} selected";
    app.resources["COMPARE_PLURAL"] ="{0}/{1} selected";
    app.resources["COMPARE_INFORM"] ="0/{0} selected";
    /* bonus products messages*/
    app.resources["BONUS_PRODUCTS"]="Bonus Product(s)";
    app.resources["SELECT_BONUS_PRODUCT"]="Select";
    app.resources["BONUS_PRODUCT_MAX"]="The maximum number of bonus products have been selected.  Please remove one in order to add additional bonus products.";
    app.resources['QUICKVIEW_TITLE']="Edit Product";
    app.resources['ADD_TO_CART_BUTTON_TITLE']="Add To Bag";
    app.resources['PRE_ORDER_BUTTON_TITLE']="Pre-order Now";
    app.resources['BACK_ORDER_BUTTON_TITLE']="Backorder add to bag";
    app.resources['UPDATE_BUTTON_TITLE']="Update";
    /* miproduct page*/
    app.resources["BLOCKER_MESSAGE_title"]="You are leaving the current page.";
    app.resources["BLOCKER_MESSAGE_message"]="Your design has not been saved.";
    app.resources["BLOCKER_MESSAGE_button_continue"]="Continue without saving";
    app.resources["BLOCKER_MESSAGE_button_cancel"]="Cancel";
    app.resources["BLOCKER_MESSAGE_survey_text"]="Help us make customization even easier.<br />Please tell us what you think.";
    app.resources["BLOCKER_MESSAGE_survey_linktext"]="Take our survey";
    app.resources["DESIGN_GALLERY_TITLE"]="Design Search";
    app.resources["DESIGN_GALLERY_CLOSE1"]="The";
    app.resources["DESIGN_GALLERY_CLOSE2"]="Gallery";
    /* personalization*/
    app.resources["LEARN_MORE_URL"] = "/on/demandware.store/Sites-adidas-US-Site/en_US/Page-Include?cid=personalization-learn-more";
    app.resources["LEARN_MORE_URL_FTW"] = "/on/demandware.store/Sites-adidas-US-Site/en_US/Page-Include?cid=personalization-learn-more-ftw";
    app.resources["LEARN_MORE_TITLE"] = "?";
    app.resources["PERSONALIZED_PRODUCT_BASKET_CHECK_URL"] = "/on/demandware.store/Sites-adidas-US-Site/en_US/Cart-PersonalizedProductCountInBasket?size=13";
    app.resources["TOO_MANY_PERSONALIZED_IN_BASKET"] = "You added too many personalization products to the basket";
    app.resources["OUT_OF_STOCK"] = "The personalization you’ve created is unavailable based on the combination of letters and numbers selected. Alternate combinations may be available.";
    app.resources["BADGE_OUT_OF_STOCK"] = "Your personalization is unavailable based on the combination of letters and numbers selected. Alternate combinations may be available.";
    app.resources["SERVICE_ERROR"] = "Oops, something went wrong. Could you please try again?";
    app.resources["PERSONALIZATION_BASE_URL"] = "https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/PersonalizationService-Start";
    app.resources["NOT_VALID_INPUT_PERSONALIZATION"] = "Sorry, this is not supported by our system. Please try again.";
    app.resources["NOT_VALID_INPUT_SPECIFY_VALUE"] = "Please specify value";
    app.resources["PERSONALIZATION_ADD_A_BADGE"] = "Add a badge";
    app.resources["PERSONALIZATION_PREVIEW"] = "Preview";
    app.resources["MIADIDAS_BASE_URL"] = "http://cfg.adidas.com";
    app.resources["CLEAR_ALL"] = "Clear all";
    app.resources["FOOTWEAR_HEADER"] = "Add something personal";
    /* search suggestions*/
    app.resources["ENABLE_DEMANDWARE_SUGGESTIONS"] = true;
    app.resources["ENABLE_CATEGORY_SUGGESTIONS"] = false;
    app.resources["ENABLE_PRODUCT_SUGGESTIONS"] = true;
    app.resources["MINIMUM_CHARACTERS_FOR_SUGGESTION"] = 3;
    app.resources["SEARCH_SUGGESTIONS"] = "Suggestions";
    app.resources["CATEGORY_SUGGESTIONS"] = "Categories";
    app.resources["PRODUCT_SUGGESTIONS"] = "Products";
    app.resources["PRODUCT_SUGGESTIONS_PRICE"] = "Price:";
    app.resources["VIEW_ALL_RESULTS_SUGGESTIONS"] = "View All Results";
    app.resources["VIEW_ALL"] = "View All";
    app.resources["RESULTS"] = "results";
    // redirects
    app.resources["REDIRECT_TITLE"] = "You will be redirected";
    app.resources["REDIRECT_CTA"] = "CONTINUE";
    app.resources["REDIRECT_MESSAGE"] = "to our adidas {0} online shop. This is where you find the widest range of {1} products. Your account details are all the same, but you will have a different shopping bag to fill. In case of questions, a team of specialty sports customer service advisors are here to help.";
    app.resources["REDIRECT_HOSTNAMES"] = "y-3,adidasbodycare,adidasspecialtysports,adidashardware";
    app.resources["REDIRECT_NAMES"] = "";
    /* CO DocumentTypeID validation */
    app.resources["FORMS_DOCUMENTTYPEID_NIT_ERROR"] = "Invalid NIT value!";
    app.resources["FORMS_DOCUMENTTYPEID_CC_ERROR"] = "Invalid CC value!";
    app.resources["FORMS_DOCUMENTTYPEID_CE_ERROR"] = "Invalid CE value!";
    app.resources["FORMS_DOCUMENTTYPEID_Pasaport_ERROR"] = "Invalid Passport value!";
    app.resources["FORMS_DOCUMENTTYPEID_TI_ERROR"] = "Invalid TI value!";
    /* waitlist*/
    app.resources["WAITLIST"] = true;
    /* expandable block*/
    app.resources["EXPANDABLE_READ_MORE"] = "Read more";
    app.resources["EXPANDABLE_READ_LESS"] = "Read less";
    /* Adyen*/
    app.resources["ADYENERRORS_CARD_EXPIRED"] = "errorforms.adyenencrypted.expiryDate.valueerror";
    /*NEWSLETTERS*/
    app.resources['VALID_EMAIL_ERROR'] = "Please enter a valid Email Address";
    app.resources['NEWSLETTER_SUBSCRIBE_URL'] = "https://www.adidas.com/us/subscribe";
    app.resources['NEWSLETTER_SUBSCRIBE_FOOTER_LABEL'] = "Sign up for news & get <span>15% off<\/span>";
    app.resources['SIGNUPANDSAVE_GENERAL_ERROR'] = "Oops, we're sorry! Because of site maintenance this service is not available.";
    app.resources['LEGAL_NEWSLETTER_AGE_CONSENTTYPE'] = "dob-dropdowns";
    app.resources["SHIPPING_METHOD_DEPENDENCIES"] = "%7B%22dwfrm_delivery_singleshipping_shippingAddress_addressFields_countyProvince%22%3A%20%22stateCode%22%2C%20%22dwfrm_delivery_singleshipping_shippingAddress_addressFields_address1%22%3A%20%22address1%22%2C%20%22dwfrm_delivery_singleshipping_shippingAddress_addressFields_address2%22%3A%20%22address2%22%7D";
    app.resources['SHIPPING_OPTIONS'] = 'Delivery Method <div class="floated-popup"><a class="showdialog" href="/on/demandware.store/Sites-adidas-US-Site/en_US/Page-Include?cid=basket-shippinginfo-content" data-component="common/ShowDialog">&nbsp;<\/a><\/div>';
    app.resources["FORM_REGEXP_EMAIL"] = "^[^\\s@.]+(\\.[^\\s@.]+)*@[A-Za-z\\d]([\\w\\-]*([A-Za-z0-9]\\.[A-Za-z0-9])*)*([A-Za-z0-9]\\.[A-Za-z]{2,})$";

    app.resources["PROFILE_TERMSCONDITIONS"] = "Terms & Conditions";
    app.resources["PROFILE_WHATDOESTHATMEAN"] = "What does that mean?";
    app.resources["PROMO_CODE_VALIDATION_URL"] = "/on/demandware.store/Sites-adidas-US-Site/en_US/Cart-Submits";
    app.isPostamatEnabled = false;
    app.isCollectPointEnabled = false;
    app.isClickCollectEnabled= false;
    app.resources["MOBILE_PHONE_INVALID"] = "";
    app.resources["MOBILE_PHONE_PATTERN"] = "";
    app.resources["MI_SHOW_MIADIDAS_USP"] = true;
    /*Product Video*/
    app.resources["SCENE7_VIDEO_URL"] = "http://s7g10.scene7.com";
    /*coming soon*/
    app.resources["COMING_SOON_GENERAL_ERROR"] = "Sorry, sign up not available, please try again later";



    app.resources["COUNTRY_RELY_ON_COOKIE"] = false;

    app.disableWorkaroundForTrusteOverlay = false
    app.constants.PERSONALIZATION_LOCALE = "";

    return app;
    }());app.define&&app.define('app.resources',function (){return app;});

    app.URLs.currentMobileUrl = "https://m.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Cart-Show";
    (function (app, init) {
    var getWaitLoading = function (callback) {
    var loading = 0,
    loaded = 0;
    return function (script) {
    var tid;
    loading++;
    script.onload = script.onreadystatechange = function() {
    if (!this.readyState || this.readyState === "loaded" || this.readyState === "complete") {
    if (tid) {
    clearTimeout(tid);
    }
    if (++loaded === loading) {
    callback();
    }
    }
    };
    tid = setTimeout(function () {
    script.onload = script.onreadystatechange = undefined;
    if (++loaded === loading) {
    callback();
    }
    }, 1000 * 10);
    };
    };
    app.firstDomReady = new jQuery.Deferred();
    jQuery(function () {
    app.firstDomReady.resolve();
    });
    if (app.isBuilded === true) {
    var scripts = app.bundlesRequired,
    head = document.getElementsByTagName("head")[0] || document.documentElement,
    loader = getWaitLoading(function(){
    init();
    });
    for (var i = 0; i < scripts.length; ++i) {
    var script = document.createElement('SCRIPT');
    script.setAttribute('type','text/javascript');
    script.async=true;
    script.src=scripts[i];
    loader(script);
    head.appendChild(script);
    }
    } else {
    init();
    }
    }(window.app, function () {





    app.require.config({
    baseUrl: "https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/en_US/v1473925034493/js",
    catchError: true,
    paths: {

    "avplayer": "//www.adidas.com/video/com/assets/js/aplayer",
    "ComponentMgr": "core/component/ComponentMgr",
    "Component": "core/component/Component",
    "PageContext": "utils/PageContext",
    "Analytics": "utils/Analytics",

    "ChatAgent": "https://adidas-group-gb.widget.custhelp.com/euf/rightnow/RightNow.Client",

    "jstorage": "vendor/jstorage.min"
    },
    waitSeconds: 0,
    map: {
    "*": {
    "styles": "vendor/require-css",
    "instance": "utils/require-instance",
    "text": "utils/require-text"
    }
    },
    shim: {
    },
    deps: [
    null,
    "jquery",
    "app.resources",
    "ComponentMgr",
    "PageContext",
    "Analytics",
    "utils/forms",
    "core/Application",
    "component/analytics/CertonaRecommendations",
    "vendor/modernizr.custom",
    "utils/social-sharing",
    "utils/jquery-ext",
    "utils/notification-broker"
    ],
    callback: function (dependencies, jQuery, res, ComponentMgr, PageContext, Analytics, forms, Application, CertonaRecommendations, Modernizr, socialSharing) {
    app.firstDomReady.then(function () {
    ComponentMgr.selectorToComponent({
    '.showdialog': 'common/ShowDialog',
    '.showpopup': 'common/Popup',
    '.collapsible': 'common/Collapsible',
    '.dataswitch': 'common/Dataswitch',
    '.expandable-content': 'common/ExpandableBlocks',
    '.tooltip': 'common/Tooltip'

    });
    ComponentMgr.setRequiredComponents([
    "component/analytics/CertonaRecommendations",
    "component/common/header/HeaderRedesign",
    "component/common/header/SearchRedesign",
    "component/common/header/PrivacyLaw",
    "component/common/header/SignUpAndSave",
    "component/common/header/SlidePanel",
    "component/checkout/MiniCart"
    ]);
    ComponentMgr.setDependencies(dependencies, "cart");
    ComponentMgr.initComponents();
    });
    // this is a hack
    Application.onLoad(function () {
    jQuery('#frameContainer').css('visibility', 'visible');
    });
    }
    });

    }));
    </script>
    <script src="https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/en_US/v1473925034493/internal/jscript/dwac-14.8.js" type="text/javascript">
    </script>
    <script type="text/javascript">
    //<!--
    /* <![CDATA[ (head-cquotient.js) */
    var CQuotient = window.CQuotient = {};
    CQuotient.clientId = 'aaqx-adidas-US';
    CQuotient.activities = [];
    CQuotient.cqcid='';
    CQuotient.cquid='';
    CQuotient.initFromCookies = function () {
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf('cqcid=') == 0) {
      CQuotient.cqcid=c.substring('cqcid='.length,c.length);
    } else if (c.indexOf('cquid=') == 0) {
      CQuotient.cquid=c.substring('cquid='.length,c.length);
      break;
    }
    }
    }
    CQuotient.getCQCookieId = function () {
    if(window.CQuotient.cqcid == '')
    window.CQuotient.initFromCookies();
    return window.CQuotient.cqcid;
    };
    CQuotient.getCQUserId = function () {
    if(window.CQuotient.cquid == '')
    window.CQuotient.initFromCookies();
    return window.CQuotient.cquid;
    };
    /* ]]> */
    // -->
    </script>
    <script src="https://tags.tiqcdn.com/utag/adidas/adidasglobal/prod/utag.sync.js" type="text/javascript">
    </script>
</head>
<body class="adidas-US">
    <div class="pt_cart cart-empty" id="container">
        <div class=" header-sticky-wrapper header-sticky-selfservice-wrapper-main" data-component="common/header/HeaderRedesign" data-sticky="true">
            <div class=" header-selfservice-wrapper">
                <div class="header-redesign header-selfservice loading-resources" id="selfservice-header">
                    <div class="wrapper clearfix">
                        <div class="selfservice-bg clearfix">
                            <div class="account selfservice">
                                <ul class="selfservice-list">
                                    <!-- <li class="account-item"><a href="#">loyality</a></li>
<li class="account-item"><a href="#">saved items</a></li>
<li class="account-item"><a href="http://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Order-Track" manual_cm_sp="header-_-profilenotloggedin-_-orderstatus">Order tracker</a></li> -->
                                    <li class="selfservice-item-suas">
                                        <a class="selfservice-link-suas sign-up-and-save" href="#" title="Newsletter Signup"></a>
                                    </li>
                                    <li class="selfservice-item-login">
                                        <a class="selfservice-link-login" href="https://www.adidas.com/us/myaccount" title="Login"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="signupandsavecontent selfservice-signupandsavecontent" data-component="common/header/SignUpAndSave" data-custom1="Guest" data-customer-code="8151298043">
                        <div class="signupandsave_start">
                            <div class="signup">
                                <div class="callout-bars" data-component="content/CalloutBar" data-contentslot="selfservice-promo-callout">
                                    <div class="callout-bar slot-content-contain clearfix" data-contentassetid="header-ssn-products" data-contentslot="selfservice-promo-callout" data-excludeforcustomize="true" tabindex="0">
                                        <img class="base" height="88" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/default/dwb5c087f6/logo/mail.png" width="88">
                                        <div class="callout-bar-copy">
                                            <span class="readmore">Subscribe for email to stay up to date</span>
                                            <div class="callout-overlay-content" data-title="Subscribe for email to stay up to date">
                                                <span class="callout-bar-body">test for products</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="callout-bar slot-content-contain clearfix" data-contentassetid="header-ssn-free-delivery-over-150" data-contentslot="selfservice-promo-callout" data-excludeforcustomize="true" tabindex="0">
                                        <img class="base" height="88" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/default/dw4984bd3d/logo/percent.png" width="88">
                                        <div class="callout-bar-copy">
                                            <span class="readmore">Save 15% on your next order</span>
                                            <div class="callout-overlay-content" data-title="Save 15% on your next order">
                                                <span class="callout-bar-body"></span>
                                                <p><span class="callout-bar-body">Title</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="callout-bar last slot-content-contain clearfix" data-contentassetid="header-ssn-free-returns" data-contentslot="selfservice-promo-callout" data-excludeforcustomize="true" tabindex="0">
                                        <img class="base" height="88" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/default/dw539f50c4/logo/star.png" width="88">
                                        <div class="callout-bar-copy">
                                            <span class="readmore">Exclusive offers &amp; promotions</span>
                                            <div class="callout-overlay-content" data-title="Exclusive offers &amp; promotions">
                                                <span class="callout-bar-body"></span>
                                                <p><span class="callout-bar-body">Not the right size or colour? No problem! Your order is picked up when &amp; where you like.</span></p>
                                                <p><span class="callout-bar-body">&nbsp;</span></p>
                                                <p><span class="callout-bar-body">Customised products are made just for you and therefore cannot be returned.</span></p>
                                                <p><span class="callout-bar-body">&nbsp;</span></p>
                                                <p><span class="callout-bar-body">Check out our <a href="https://www.adidas.com/us/help-topics-terms_and_conditions.html">Return Policy</a> for more details.</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form action="https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Newsletter-Submits" class="signupandsaveform suppress validate fancyform signupandsaveform-full" data-component="form/Form" id="signupandsaveform" method="post" name="signupandsaveform">
                                <fieldset>
                                    <div class="general_error"></div>
                                    <div class="signupandsaveform-body clearfix">
                                        <div class="formfield email require">
                                            <label class="" for="dwfrm_profile_customer_email">Email</label>
                                            <div class="value">
                                                <label class="label-off" for="dwfrm_profile_customer_email"></label> <input class="textinput required focusout required" data-missing-error="Please enter a valid e-mail address" data-parse-error="Please enter a valid e-mail address" data-range-error="Value too long or too short" id="dwfrm_profile_customer_email" maxlength="50" name="dwfrm_profile_customer_email" required="required" type="text" value=""> <!-- display text area input field -->

                                                <script data-component="common/HiddenJson" type="text/json">
                                                {label:"Email"}
                                                </script> <!-- this MUST be immediately after the input/field tag. Hiden data to be attached to the input field (app.hiddenData in app.js -->
                                            </div><span class="errormessage" style="display: none;"></span>
                                            <div class="caption">
                                                For first time subscribers only
                                            </div>
                                        </div>
                                        <div class="formfield require js_consents selfsevicesignup">
                                            <div class="birthday_wrapper clearfix">
                                                <div class="formfield birthday clearfix mandatory" id="birthday-field-original">
                                                    <label class="label-manual">Date of Birth <span class="label">&nbsp;*&nbsp;</span></label> <!--  -->
                                                    <div class="value value-select">
                                                        <label class="label-off" for="dwfrm_profile_customer_birthday_dayofmonth">Day</label> <select class="required" data-missing-error="Date of birth is a required field" id="dwfrm_profile_customer_birthday_dayofmonth" name="dwfrm_profile_customer_birthday_dayofmonth" required="required">
                                                            <option class="first-option" value="">
                                                                Day
                                                            </option>
                                                            <option value="1">
                                                                1
                                                            </option>
                                                            <option value="2">
                                                                2
                                                            </option>
                                                            <option value="3">
                                                                3
                                                            </option>
                                                            <option value="4">
                                                                4
                                                            </option>
                                                            <option value="5">
                                                                5
                                                            </option>
                                                            <option value="6">
                                                                6
                                                            </option>
                                                            <option value="7">
                                                                7
                                                            </option>
                                                            <option value="8">
                                                                8
                                                            </option>
                                                            <option value="9">
                                                                9
                                                            </option>
                                                            <option value="10">
                                                                10
                                                            </option>
                                                            <option value="11">
                                                                11
                                                            </option>
                                                            <option value="12">
                                                                12
                                                            </option>
                                                            <option value="13">
                                                                13
                                                            </option>
                                                            <option value="14">
                                                                14
                                                            </option>
                                                            <option value="15">
                                                                15
                                                            </option>
                                                            <option value="16">
                                                                16
                                                            </option>
                                                            <option value="17">
                                                                17
                                                            </option>
                                                            <option value="18">
                                                                18
                                                            </option>
                                                            <option value="19">
                                                                19
                                                            </option>
                                                            <option value="20">
                                                                20
                                                            </option>
                                                            <option value="21">
                                                                21
                                                            </option>
                                                            <option value="22">
                                                                22
                                                            </option>
                                                            <option value="23">
                                                                23
                                                            </option>
                                                            <option value="24">
                                                                24
                                                            </option>
                                                            <option value="25">
                                                                25
                                                            </option>
                                                            <option value="26">
                                                                26
                                                            </option>
                                                            <option value="27">
                                                                27
                                                            </option>
                                                            <option value="28">
                                                                28
                                                            </option>
                                                            <option value="29">
                                                                29
                                                            </option>
                                                            <option value="30">
                                                                30
                                                            </option>
                                                            <option value="31">
                                                                31
                                                            </option>
                                                        </select> <label class="label-off" for="dwfrm_profile_customer_birthday_month">Month</label> <select class="required" data-missing-error="Date of birth is a required field" id="dwfrm_profile_customer_birthday_month" name="dwfrm_profile_customer_birthday_month" required="required">
                                                            <option class="first-option" value="">
                                                                Month
                                                            </option>
                                                            <option value="0">
                                                                1
                                                            </option>
                                                            <option value="1">
                                                                2
                                                            </option>
                                                            <option value="2">
                                                                3
                                                            </option>
                                                            <option value="3">
                                                                4
                                                            </option>
                                                            <option value="4">
                                                                5
                                                            </option>
                                                            <option value="5">
                                                                6
                                                            </option>
                                                            <option value="6">
                                                                7
                                                            </option>
                                                            <option value="7">
                                                                8
                                                            </option>
                                                            <option value="8">
                                                                9
                                                            </option>
                                                            <option value="9">
                                                                10
                                                            </option>
                                                            <option value="10">
                                                                11
                                                            </option>
                                                            <option value="11">
                                                                12
                                                            </option>
                                                        </select> <label class="label-off" for="dwfrm_profile_customer_birthday_year">Year</label> <select class="required" data-missing-error="Date of birth is a required field" id="dwfrm_profile_customer_birthday_year" name="dwfrm_profile_customer_birthday_year" required="required">
                                                            <option class="first-option" value="">
                                                                Year
                                                            </option>
                                                            <option value="2016">
                                                                2016
                                                            </option>
                                                            <option value="2015">
                                                                2015
                                                            </option>
                                                            <option value="2014">
                                                                2014
                                                            </option>
                                                            <option value="2013">
                                                                2013
                                                            </option>
                                                            <option value="2012">
                                                                2012
                                                            </option>
                                                            <option value="2011">
                                                                2011
                                                            </option>
                                                            <option value="2010">
                                                                2010
                                                            </option>
                                                            <option value="2009">
                                                                2009
                                                            </option>
                                                            <option value="2008">
                                                                2008
                                                            </option>
                                                            <option value="2007">
                                                                2007
                                                            </option>
                                                            <option value="2006">
                                                                2006
                                                            </option>
                                                            <option value="2005">
                                                                2005
                                                            </option>
                                                            <option value="2004">
                                                                2004
                                                            </option>
                                                            <option value="2003">
                                                                2003
                                                            </option>
                                                            <option value="2002">
                                                                2002
                                                            </option>
                                                            <option value="2001">
                                                                2001
                                                            </option>
                                                            <option value="2000">
                                                                2000
                                                            </option>
                                                            <option value="1999">
                                                                1999
                                                            </option>
                                                            <option value="1998">
                                                                1998
                                                            </option>
                                                            <option value="1997">
                                                                1997
                                                            </option>
                                                            <option value="1996">
                                                                1996
                                                            </option>
                                                            <option value="1995">
                                                                1995
                                                            </option>
                                                            <option value="1994">
                                                                1994
                                                            </option>
                                                            <option value="1993">
                                                                1993
                                                            </option>
                                                            <option value="1992">
                                                                1992
                                                            </option>
                                                            <option value="1991">
                                                                1991
                                                            </option>
                                                            <option value="1990">
                                                                1990
                                                            </option>
                                                            <option value="1989">
                                                                1989
                                                            </option>
                                                            <option value="1988">
                                                                1988
                                                            </option>
                                                            <option value="1987">
                                                                1987
                                                            </option>
                                                            <option value="1986">
                                                                1986
                                                            </option>
                                                            <option value="1985">
                                                                1985
                                                            </option>
                                                            <option value="1984">
                                                                1984
                                                            </option>
                                                            <option value="1983">
                                                                1983
                                                            </option>
                                                            <option value="1982">
                                                                1982
                                                            </option>
                                                            <option value="1981">
                                                                1981
                                                            </option>
                                                            <option value="1980">
                                                                1980
                                                            </option>
                                                            <option value="1979">
                                                                1979
                                                            </option>
                                                            <option value="1978">
                                                                1978
                                                            </option>
                                                            <option value="1977">
                                                                1977
                                                            </option>
                                                            <option value="1976">
                                                                1976
                                                            </option>
                                                            <option value="1975">
                                                                1975
                                                            </option>
                                                            <option value="1974">
                                                                1974
                                                            </option>
                                                            <option value="1973">
                                                                1973
                                                            </option>
                                                            <option value="1972">
                                                                1972
                                                            </option>
                                                            <option value="1971">
                                                                1971
                                                            </option>
                                                            <option value="1970">
                                                                1970
                                                            </option>
                                                            <option value="1969">
                                                                1969
                                                            </option>
                                                            <option value="1968">
                                                                1968
                                                            </option>
                                                            <option value="1967">
                                                                1967
                                                            </option>
                                                            <option value="1966">
                                                                1966
                                                            </option>
                                                            <option value="1965">
                                                                1965
                                                            </option>
                                                            <option value="1964">
                                                                1964
                                                            </option>
                                                            <option value="1963">
                                                                1963
                                                            </option>
                                                            <option value="1962">
                                                                1962
                                                            </option>
                                                            <option value="1961">
                                                                1961
                                                            </option>
                                                            <option value="1960">
                                                                1960
                                                            </option>
                                                            <option value="1959">
                                                                1959
                                                            </option>
                                                            <option value="1958">
                                                                1958
                                                            </option>
                                                            <option value="1957">
                                                                1957
                                                            </option>
                                                            <option value="1956">
                                                                1956
                                                            </option>
                                                            <option value="1955">
                                                                1955
                                                            </option>
                                                            <option value="1954">
                                                                1954
                                                            </option>
                                                            <option value="1953">
                                                                1953
                                                            </option>
                                                            <option value="1952">
                                                                1952
                                                            </option>
                                                            <option value="1951">
                                                                1951
                                                            </option>
                                                            <option value="1950">
                                                                1950
                                                            </option>
                                                            <option value="1949">
                                                                1949
                                                            </option>
                                                            <option value="1948">
                                                                1948
                                                            </option>
                                                            <option value="1947">
                                                                1947
                                                            </option>
                                                            <option value="1946">
                                                                1946
                                                            </option>
                                                            <option value="1945">
                                                                1945
                                                            </option>
                                                            <option value="1944">
                                                                1944
                                                            </option>
                                                            <option value="1943">
                                                                1943
                                                            </option>
                                                            <option value="1942">
                                                                1942
                                                            </option>
                                                            <option value="1941">
                                                                1941
                                                            </option>
                                                            <option value="1940">
                                                                1940
                                                            </option>
                                                            <option value="1939">
                                                                1939
                                                            </option>
                                                            <option value="1938">
                                                                1938
                                                            </option>
                                                            <option value="1937">
                                                                1937
                                                            </option>
                                                            <option value="1936">
                                                                1936
                                                            </option>
                                                            <option value="1935">
                                                                1935
                                                            </option>
                                                            <option value="1934">
                                                                1934
                                                            </option>
                                                            <option value="1933">
                                                                1933
                                                            </option>
                                                            <option value="1932">
                                                                1932
                                                            </option>
                                                            <option value="1931">
                                                                1931
                                                            </option>
                                                            <option value="1930">
                                                                1930
                                                            </option>
                                                            <option value="1929">
                                                                1929
                                                            </option>
                                                            <option value="1928">
                                                                1928
                                                            </option>
                                                            <option value="1927">
                                                                1927
                                                            </option>
                                                            <option value="1926">
                                                                1926
                                                            </option>
                                                            <option value="1925">
                                                                1925
                                                            </option>
                                                            <option value="1924">
                                                                1924
                                                            </option>
                                                            <option value="1923">
                                                                1923
                                                            </option>
                                                            <option value="1922">
                                                                1922
                                                            </option>
                                                            <option value="1921">
                                                                1921
                                                            </option>
                                                            <option value="1920">
                                                                1920
                                                            </option>
                                                            <option value="1919">
                                                                1919
                                                            </option>
                                                            <option value="1918">
                                                                1918
                                                            </option>
                                                            <option value="1917">
                                                                1917
                                                            </option>
                                                            <option value="1916">
                                                                1916
                                                            </option>
                                                        </select>
                                                    </div><a class="asking_button" data-component="common/ShowDialog" title="">?</a>
                                                    <div class="ui-dialog asking">
                                                        <a class="close cancel" title="Close">Close</a>
                                                        <p>adidas collects date of birth to comply with the Privacy Policy</p><button class="cancel button-primary bp-black light-back co-btn_primary btn_tertiary btn-regular-dark btn btn-dark" title="Close" type="button"><span>Close</span></button>
                                                    </div><span class="errormessage" style="display:none;"></span>
                                                    <div class="errormsg-wrap">
                                                        <span class="errormsg hidden">Date of birth is a required field</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="formfield gender">
                                            <fieldset>
                                                <div class="label">
                                                    <legend>Gender</legend>
                                                </div>
                                                <div class="ageconfirmatininp">
                                                    <input name="gender" type="hidden" value="0"> <input id="dwfrm_profile_customer_gender_1" name="dwfrm_profile_customer_gender" type="radio" value="1"> <label for="dwfrm_profile_customer_gender_1">Male</label> <input id="dwfrm_profile_customer_gender_2" name="dwfrm_profile_customer_gender" type="radio" value="2"> <label for="dwfrm_profile_customer_gender_2">Female</label>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="signin-actions">
                                            <a class="button-primary btn-regular-red bp-blue light-back co-btn_primary btn btn-red" id="newsletterheadersubmitwomen" name="dwfrm_profile_subscribe"><span>Sign Up</span></a>
                                        </div>
                                    </div>
                                    <p class="legal-copy-content">Sign me up for adidas emails, featuring exclusive offers, latest product info, news about upcoming events, and more. See our <a href="/us/help-topics-privacy_policy.html" target="_blank">Privacy Policy</a> for details.</p>
                                    <script id="legalcontentpopup" type="text/template">
                                    <div class="signupandsavedialog"></div>
                                    </script>
                                </fieldset>
                            </form>
                        </div>
                        <div class="signupandsave_complete">
                            <h3 class="signupandsave_complete-title">Sign Up Complete</h3>
                            <p class="signupandsave_complete-content">You will receive a confirmation to <span></span></p>
                        </div>
                        <div class="loading_wrapper">
                            <div class="loading">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-redesign loading-resources" id="header">
                <div class="wrapper clearfix">
                    <div class="column column-logo">
                    </div>
                    <div class="column topcat-nav" data-component="content/ExternalLinks" data-linkscontext="header">
                        <div class="flyout navigation-gender-men">
                            <div class="nav-button">
                                <a class="top-cat-link" href="http://www.adidas.com/us/men">Turtles</a>
                            </div>
                            <div class="flyout-content">
                                <div class="contentasset" data-contentasset="navigation-gender-men" data-contentasset-id="navigation-gender-men">
                                    <div class="flyout-content-in">
                                        <div class="main-line">
                                            <div class="col-5">
                                                <div class="headline">
                                                    featured
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-new_arrivals">New Arrivals</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-best_sellers">Best Sellers</a>
                                                    </li>
                                                    <li><strong><a href="http://www.adidas.com/us/men-sale">Sale - New Markdowns Added</a></strong></li>
                                                    <li>&nbsp;</li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-zne">Z.N.E.</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-iconics">Iconics</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-tubular">Tubular</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-5">
                                                <div class="headline">
                                                    shoes
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-originals-shoes">Originals</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-soccer-shoes">Soccer</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-running-shoes">Running</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-basketball-shoes">Basketball</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-training-shoes">Training</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-outdoor-shoes">Outdoor</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-football-cleats">Football</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-baseball1-shoes">Baseball</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-tennis-shoes">Tennis</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-slides">Sandals & Slides</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-neo-shoes">NEO</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/customize?prefn1=gender&amp;prefv1=Men">Customize with mi adidas</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-5">
                                                <div class="headline">
                                                    Apparel
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-jackets">Jackets</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-hoodies">Hoodies & Sweatshirts</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-track_suits">Track Suits & Warm Ups</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-long_sleeve_tops">Long Sleeve Tops</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-short_sleeve_tops">Short Sleeve Tops</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-graphic_tees">Graphic Tees</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-sleeveless_tops">Sleeveless Tops</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-jerseys">Jerseys</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-pants">Pants</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-tights">Tights</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-shorts">Shorts</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-5">
                                                <div class="headline">
                                                    accessories
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-bags">Bags</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-balls">Balls</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-sunglasses">Sunglasses</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-watches">Watches</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-gloves">Gloves</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-hats">Hats</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-socks">Socks</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-underwear">Underwear</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-scarves">Scarves</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-5">
                                                <div class="headline">
                                                    sports
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-soccer">Soccer</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-running">Running</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-basketball">Basketball</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-training">Training</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-football">Football</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-baseball1">Baseball</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-tennis">Tennis</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-outdoor">Outdoor</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-weightlifting">Weightlifting</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-skateboarding1">Skateboarding</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/snowboarding">Snowboarding</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-hockey">Hockey</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-lacrosse">Lacrosse</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-volleyball">Volleyball</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="bottom-line">
                                            <!-- <div class="col-5">&nbsp;</div> -->
                                            <!-- <div class="col-5"><a href="http://www.adidas.com/us/men-shoes"><strong>Shop all Men's Shoes</strong></a></div> -->
                                            <!-- <div class="col-5"><a href="http://www.adidas.com/us/men-apparel"><strong>Shop all Men's Apparel</strong></a></div> -->
                                            <!-- <div class="col-5"><a href="http://www.adidas.com/us/men-accessories"><strong>Shop all Men's Accesories</strong></a></div> -->
                                            <!-- <div class="col-5"><a href="http://www.adidas.com/us/men"><strong>Shop all Men's</strong></a></div> -->
                                        </div>
                                    </div>
                                </div><!-- End contentasset -->
                            </div>
                        </div>
                        <div class="flyout navigation-gender-women">
                            <div class="nav-button">
                                <a class="top-cat-link" href="http://www.adidas.com/us/women">Koalas</a>
                            </div>
                            <div class="flyout-content">
                                <div class="contentasset" data-contentasset="navigation-gender-women" data-contentasset-id="navigation-gender-women">
                                    <div class="flyout-content-in">
                                        <div class="main-line">
                                            <div class="col-5">
                                                <div class="headline">
                                                    featured
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-new_arrivals">New Arrivals</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-best_sellers">Best Sellers</a>
                                                    </li>
                                                    <li><strong><a href="http://www.adidas.com/us/women-sale">Sale - New Markdowns Added</a></strong></li>
                                                    <li>&nbsp;</li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-zne">Z.N.E.</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/pureboost_x?grid=true">Pureboost X</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-iconics">Iconics</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/rita_ora">Rita Ora</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-5">
                                                <div class="headline">
                                                    shoes
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-originals-shoes">Originals</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-soccer-shoes">Soccer</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-running-shoes">Running</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-training-shoes">Training</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-basketball-shoes">Basketball</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-tennis-shoes">Tennis</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-outdoor-shoes">Outdoor</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-softball-shoes">Softball</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-slides">Sandals & Slides</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-neo-shoes">NEO</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/customize?prefn1=gender&prefv1=Women">Customize with mi adidas</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-5">
                                                <div class="headline">
                                                    Apparel
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-jackets">Jackets</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-hoodies">Hoodies & Sweatshirts</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-track_suits">Track Suits & Warm Ups</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-long_sleeve_tops">Long Sleeve Tops</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-short_sleeve_tops%7Cgraphic_tees">Short Sleeve Tops</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-sleeveless_tops">Sleeveless Tops</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-bras">Sports Bras</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-pants">Pants</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-tights">Tights</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-shorts">Shorts</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-5">
                                                <div class="headline">
                                                    Accessories
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-bags">Bags</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-balls">Balls</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-sunglasses">Sunglasses</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-watches">Watches</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-gloves">Gloves</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-hats">Hats</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-socks">Socks</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-underwear">Underwear</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-scarves">Scarves</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-5">
                                                <div class="headline">
                                                    sports
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-soccer">Soccer</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-running">Running</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-training">Training</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-basketball">Basketball</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-softball">Softball</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-tennis">Tennis</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-outdoor">Outdoor</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/skateboarding">Skateboarding</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/snowboarding">Snowboarding</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-lacrosse">Lacrosse</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-volleyball">Volleyball</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-yoga">Yoga</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="bottom-line">
                                            <!-- <div class="col-5">&nbsp;</div> -->
                                            <!-- <div class="col-5"><a href="http://www.adidas.com/us/women-shoes"><strong>Shop all Women&#39;s Shoes</strong></a></div> -->
                                            <!-- <div class="col-5"><a href="http://www.adidas.com/us/women-apparel"><strong>Shop all Women&#39;s Apparel</strong></a></div> -->
                                            <!-- <div class="col-5"><a href="http://www.adidas.com/us/women-accessories"><strong>Shop all Women&#39;s Accesories</strong></a></div> -->
                                            <!-- <div class="col-5"><a href="http://www.adidas.com/us/women"><strong>Shop all Women&#39;s</strong></a></div> -->
                                        </div>
                                    </div>
                                </div><!-- End contentasset -->
                            </div>
                        </div>
                        <div class="flyout navigation-gender-kids">
                            <div class="nav-button">
                                <a class="top-cat-link" href="http://www.adidas.com/us/kids">Roos</a>
                            </div>
                            <div class="flyout-content">
                                <div class="contentasset" data-contentasset="navigation-gender-kids" data-contentasset-id="navigation-gender-kids">
                                    <div class="flyout-content-in">
                                        <div class="main-line">
                                            <div class="col-5">
                                                <div class="headline">
                                                    featured
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-new_arrivals">New Arrivals</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-best_sellers">Best Sellers</a>
                                                    </li>
                                                    <li><strong><a href="http://www.adidas.com/us/kids-sale">Sale - New Markdowns Added</a></strong></li>
                                                    <li>&nbsp;</li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-back_to_school">Back to School</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-zne">Z.N.E</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/disney">Disney</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-iconics">Iconics</a>
                                                    </li><!-- <li class="horizontal-separator"></li> -->
                                                    <!-- <li><a href="http://www.adidas.com/us/kids-sale"><img alt="" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/en_US/dwd9a3010f/_other/_navigation/EOY_flyout.jpg" /></a></li> -->
                                                </ul>
                                            </div>
                                            <div class="col-5">
                                                <div class="headline">
                                                    <a href="http://www.adidas.com/us/kids-infant_toddler">infants & toddlers<br>
                                                    (0-3 years)</a>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-infant_toddler-originals-shoes">Originals Shoes</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-infant_toddler-sport-shoes">Sport Shoes</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-infant_toddler-neo-shoes">Neo Shoes</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-infant_toddler-shoes">All Shoes</a>
                                                    </li>
                                                    <li class="horizontal-separator"></li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/infant_toddler-jackets%7Cvests">Jackets & Vests</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-infant_toddler-hoodies">Hoodies & Sweatshirts</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/infant_toddler-track_suits">Track Suits & Warm Ups</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/infant_toddler-short_sleeve_tops">Short Sleeve Tops</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/infant_toddler-pants">Pants</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/infant_toddler-shorts">Shorts</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/infant_toddler-apparel">View All Apparel</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-5">
                                                <div class="headline">
                                                    <a href="http://www.adidas.com/us/children-search">Children<br>
                                                    (4-8 years)</a>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-children-originals-shoes">Originals Shoes</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-children-sport-shoes">Sport Shoes</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-children-neo-shoes">Neo Shoes</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-children-shoes">All Shoes</a>
                                                    </li>
                                                    <li class="horizontal-separator"></li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/children-jackets%7Cvests">Jackets & Vests</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-children-hoodies">Hoodies & Sweatshirts</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/children-track_suits">Track Suits & Warm Ups</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/children-short_sleeve_tops">Short Sleeve Tops</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/children-pants">Pants</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/children-shorts">Shorts</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/children-apparel">View All Apparel</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-5">
                                                <div class="headline">
                                                    <a href="http://www.adidas.com/us/youth-search">Youth<br>
                                                    (8-14 years)</a>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-youth-originals-shoes">Originals Shoes</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-youth-sport-shoes">Sport Shoes</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-youth-neo-shoes">Neo Shoes</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-youth-shoes">All Shoes</a>
                                                    </li>
                                                    <li class="horizontal-separator"></li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/youth-jackets%7Cvests">Jackets & Vests</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-youth-hoodies">Hoodies & Sweatshirts</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/youth-track_suits">Track Suits & Warm Ups</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/youth-short_sleeve_tops">Short Sleeve Tops</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/youth-pants">Pants</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/youth-shorts">Shorts</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/youth-apparel">View All Apparel</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="bottom-line">
                                            <div class="col-5">
                                                &nbsp;
                                            </div>
                                            <div class="col-5">
                                                <a href="http://www.adidas.com/us/kids-infant_toddler"><strong>Shop all Infants & Toddlers</strong></a>
                                            </div>
                                            <div class="col-5">
                                                <a href="http://www.adidas.com/us/kids-children"><strong>Shop all Children</strong></a>
                                            </div>
                                            <div class="col-5">
                                                <a href="http://www.adidas.com/us/kids-youth"><strong>Shop all Youth</strong></a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End contentasset -->
                            </div>
                        </div><span class="delimiter"></span>
                        <div class="flyout navigation-category-sports">
                            <div class="nav-button">
                                NEVERWHERE
                            </div>
                            <div class="flyout-content">
                                <div class="contentasset" data-contentasset="navigation-category-sports" data-contentasset-id="navigation-category-sports">
                                    <div class="flyout-content-in">
                                        <div class="main-line with-line">
                                            <div class="col-5">
                                                <div class="adidas-brand headline">
                                                    <a href="http://www.adidas.com/us/running">running</a> <a class="image-banner" href="http://www.adidas.com/us/running"><img alt="" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/en_US/dw2e59adfe/_other/_navigation/Running.png" style="width: 172px; height: 80px;"></a>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/running-shoes">Shoes</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/running-apparel">Apparel</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/running-accessories">Accessories</a>
                                                    </li>
                                                    <li class="horizontal-separator">&nbsp;</li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/ultra_boost">Ultra Boost</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/alphabounce?grid=true">AlphaBOUNCE</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/pureboost_x?grid=true">PureBOOST X</a>
                                                    </li>
                                                    <li class="horizontal-separator">&nbsp;</li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/running?grid=true"><strong>all Running</strong></a>
                                                    </li><!--<li><a href="http://www.adidas.com/us/running"><strong>Explore Running</strong></a></li>-->
                                                </ul>
                                            </div>
                                            <div class="col-5">
                                                <div class="headline">
                                                    <a href="http://www.adidas.com/us/soccer">Soccer</a> <a class="image-banner" href="http://www.adidas.com/us/soccer"><img alt="" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/en_US/dw5bf4e7f9/adidascom_NavImage_Football_SOL_3Players_Suarez_Pogba.jpg" style="width: 172px; height: 80px;"></a>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/soccer-shoes">Shoes</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/soccer-apparel">Apparel</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/soccer-accessories">Accessories</a>
                                                    </li>
                                                    <li class="horizontal-separator">&nbsp;</li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/ace?grid=true">Ace</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/x?grid=true">X</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/messi?grid=true">Messi</a>
                                                    </li>
                                                    <li class="horizontal-separator">&nbsp;</li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/soccer?grid=true"><strong>all Soccer</strong></a>
                                                    </li><!--<li><a href="http://www.adidas.com/us/soccer"><strong>Explore Soccer</strong></a></li>-->
                                                </ul>
                                            </div>
                                            <div class="col-5">
                                                <div class="adidas-brand headline">
                                                    <a href="http://www.adidas.com/us/basketball">basketball</a> <a class="image-banner" href="http://www.adidas.com/us/basketball"><img alt="" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/en_US/dw2bdf187d/_other/_navigation/harden-basketball.png" style="width: 172px; height: 80px;"></a>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/basketball-shoes">Shoes</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/basketball-apparel">Apparel</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/basketball-accessories">Accessories</a>
                                                    </li>
                                                    <li class="horizontal-separator">&nbsp;</li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/james_harden">James Harden</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/damian_lillard">Damian Lillard</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/crazylight">Crazylight Boost</a>
                                                    </li>
                                                    <li class="horizontal-separator">&nbsp;</li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/basketball?grid=true"><strong>all Basketball</strong></a>
                                                    </li><!--<li><a href="http://www.adidas.com/us/basketball"><strong>Explore Basketball</strong></a></li>-->
                                                </ul>
                                            </div>
                                            <div class="col-5">
                                                <div class="adidas-brand headline">
                                                    <a href="http://www.adidas.com/us/football">football</a> <a class="image-banner" href="http://www.adidas.com/us/football"><img alt="" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/default/dw4010a061/header-redesign/Football_Header.jpg" style="width: 172px; height: 80px;"></a>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/football-cleats">Cleats</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/football-apparel">Apparel</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/football-accessories">Accessories</a>
                                                    </li>
                                                    <li class="horizontal-separator">&nbsp;</li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/cleathead">Cleathead</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/football-collegiate">Collegiate</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/adizero_5_star">Adizero 5-Star</a>
                                                    </li>
                                                    <li class="horizontal-separator">&nbsp;</li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/football?grid=true"><strong>all Football</strong></a>
                                                    </li><!--<li><a href="http://www.adidas.com/us/football"><strong>Explore Football</strong></a></li>-->
                                                </ul>
                                            </div>
                                            <div class="separate col-5">
                                                <div class="adidas-brand headline">
                                                    other sports
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/training">Training</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/baseball">Baseball</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/outdoor?grid=true">Outdoor</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/skateboarding">Skateboarding</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/snowboarding">Snowboarding</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/hockey">Hockey</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/tennis">Tennis</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://adidasgolf.com/">Golf</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/lacrosse">Lacrosse</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/volleyball">Volleyball</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/yoga">Yoga</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End contentasset -->
                            </div>
                        </div>
                        <div class="flyout navigation-category-labels">
                            <div class="nav-button">
                                NEVERYDAY
                            </div>
                            <div class="flyout-content">
                                <div class="contentasset" data-contentasset="navigation-category-labels" data-contentasset-id="navigation-category-labels">
                                    <div class="flyout-content-in">
                                        <div class="main-line with-line">
                                            <div class="col-5">
                                                <div class="adidas-brand headline">
                                                    <a class="image-logo" href="http://www.adidas.com/us/originals"><span style="display: none;">originals</span><img alt="" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/en_US/dwa369c7b5/_other/_navigation/text_originals.png" style="width: 172px; height: 30px;"></a> <a class="image-banner" href="http://www.adidas.com/us/originals"><img alt="" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/en_US/dw05d3dd69/_other/_navigation/adidas-originals-fw15-header-flyout.jpg" style="width: 172px; height: 80px;"></a>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/originals-shoes">Shoes</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/originals-apparel">Apparel</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/originals-accessories">Accessories</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/originals-new_arrivals">New Arrivals</a>
                                                    </li>
                                                    <li class="horizontal-separator">&nbsp;</li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/originals-superstar-shoes">Superstar</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/stan_smith">Stan Smith</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/gazelle">Gazelle</a>
                                                    </li>
                                                    <li class="horizontal-separator">&nbsp;</li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/originals?grid=true"><strong>all adidas Originals</strong></a>
                                                    </li><!--<li><a href="http://www.adidas.com/us/originals"><strong>Explore Originals</strong></a></li>-->
                                                </ul>
                                            </div>
                                            <div class="col-5">
                                                <div class="adidas-brand headline">
                                                    <a class="image-logo" href="http://www.adidas.com/us/athletics"><span style="display: none;">adidas by Stella McCartney</span><img alt="" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/en_US/dwe98fdae3/_other/_navigation/athletics-logo-172x30.png" style="width: 172px; height: 30px;"></a> <a class="image-banner" href="http://www.adidas.com/us/athletics"><img alt="" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/en_US/dw1491338a/_other/_navigation/harden_172x80.jpg" style="width: 172px; height: 80px;"></a>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/men-athletics">Men's Apparel</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/women-athletics">Women's Apparel</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/kids-athletics">Kids Apparel</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/new_arrivals-athletics">New Arrivals</a>
                                                    </li>
                                                    <li class="horizontal-separator">&nbsp;</li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/zne">Z.N.E.</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/icon">Icon</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/essentials">Essentials</a>
                                                    </li>
                                                    <li class="horizontal-separator">&nbsp;</li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/athletics-apparel?grid=true"><strong>all Athletics</strong></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-5">
                                                <div class="adidas-brand headline">
                                                    <a class="image-logo" href="http://www.adidas.com/us/adidas_by_stella_mccartney"><span style="display: none;">adidas by Stella McCartney</span><img alt="" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/en_US/dw67e8598d/_other/_navigation/text_stella.png" style="width: 172px; height: 30px;"></a> <a class="image-banner" href="http://www.adidas.com/us/adidas_by_stella_mccartney"><img alt="" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/en_US/dw9e2d96c8/_other/_navigation/aSMC%20category%20image_small.jpg" style="width: 172px; height: 80px;"></a>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/adidas_by_stella_mccartney-shoes">Shoes</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/adidas_by_stella_mccartney-apparel">Apparel</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/adidas_by_stella_mccartney-accessories">Accessories</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/adidas_by_stella_mccartney-new_arrivals">New Arrivals</a>
                                                    </li>
                                                    <li class="horizontal-separator">&nbsp;</li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/adidas_by_stella_mccartney-tennis">Tennis</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/adidas_by_stella_mccartney-training">Studio & Yoga</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/stellasport">Stellasport</a>
                                                    </li>
                                                    <li class="horizontal-separator">&nbsp;</li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/adidas_by_stella_mccartney?grid=true"><strong>all adidas by Stella McCartney</strong></a>
                                                    </li><!-- <li><a href="http://www.adidas.com/us/adidas_by_stella_mccartney?grid=true"><strong>Explore adidas by Stella McCartney</strong></a></li> -->
                                                </ul>
                                            </div>
                                            <div class="col-5">
                                                <div class="adidas-brand headline">
                                                    <a class="image-logo" href="http://www.adidas.com/us/neo"><span style="display: none;">adidas Neo</span><img alt="" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/en_US/dwf1096fc4/_other/_navigation/text_neo.jpeg" style="width: 172px; height: 30px;"></a> <a class="image-banner" href="http://www.adidas.com/us/neo"><img alt="" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/en_US/dw55bebe00/_other/_navigation/041H_15_neo_SS16_Q2_Cont_Sports_navigation_header_R01.jpg" style="width: 172px; height: 80px;"></a>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/neo-shoes">Shoes</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/neo-apparel">Apparel</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/neo-Accessories">Accessories</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/neo-new_arrivals">New Arrivals</a>
                                                    </li>
                                                    <li class="horizontal-separator">&nbsp;</li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/cloudfoam">Cloudfoam</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/raleigh">Raleigh</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/lite_racer">Lite Racer</a>
                                                    </li>
                                                    <li class="horizontal-separator">&nbsp;</li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/neo?grid=true"><strong>all Neo</strong></a>
                                                    </li><!--<li><a href="http://www.adidas.com/us/neo"><strong>Explore NEO</strong></a></li>-->
                                                </ul>
                                            </div><!--
<div class="col-5">

<div class="adidas-brand headline">
    <a class="image-logo" href="http://www.adidas.com/us/skateboarding"><img alt="" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/default/dwf481b924/header-redesign/skate-icon.jpg" style="width: 172px; height: 30px;" /> </a>
    <a class="image-banner" href="http://www.adidas.com/us/skateboarding"> <img alt="" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/default/dw8c2c51ec/header-redesign/skate-logo.jpg" style="width: 172px; height: 80px;" /> </a></div>

<ul>
  <li><a href="http://www.adidas.com/us/skate?grid=true">adidas Skateboarding</a></li>
  <li><a href="http://www.adidas.com/us/skate-shoes">Shoes</a></li>
  <li><a href="http://www.adidas.com/us/skate-apparel">Apparel</a></li>
  <li class="horizontal-separator">&nbsp;</li>
  <li><a href="http://www.adidas.com/us/skate?grid=true">Shop all <strong>adidas Skateboarding</strong></a></li>
  <li><a href="http://www.adidas.com/us/skateboarding">Explore <strong>adidas Skateboarding</strong></a></li>
</ul>

</div>
-->
                                            <div class="separate col-5">
                                                <div class="adidas-brand headline">
                                                    collections
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/iconics">Iconics</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/tubular">Tubular</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/zx_flux">ZX Flux</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/gazelle">Gazelle</a>
                                                    </li>
                                                    <li class="horizontal-separator">&nbsp;</li><!--        <li><a href="http://www.adidas.com/us/stellasport">Stellasport</a></li> -->
                                                    <!--        <li><a href="http://www.adidas.com/us/cloudfoam">Neo Cloudfoam</a></li> -->
                                                    <li>
                                                        <a href="http://www.adidas.com/us/adicolor">adicolor Apparel</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/fashion_pack">Fashion Packs</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div><!-- <div class="bottom-line with-line">
<div class="col-5"></div>
<div class="col-5"></div>
<div class="col-5"></div>
<div class="col-5"></div>
</div>
-->
                                    </div>
                                </div><!-- End contentasset -->
                            </div>
                        </div><span class="delimiter"></span>
                        <div class="flyout navigation-services-customise">
                            <div class="nav-button">
                                <a class="top-cat-link" href="/us/customize">D3STRYR</a>
                            </div>
                            <div class="flyout-content">
                                <div class="contentasset" data-contentasset="navigation-services-customise" data-contentasset-id="navigation-services-customise">
                                    <div class="flyout-content-in">
                                        <div class="main-line">
                                            <div class="col-5">
                                                <div class="headline">
                                                    Featured
                                                </div>
                                                <div style="margin-left: 2em">
                                                    <div class="text-content">
                                                        <ul>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/shoes-personalize">Personalize Shoes</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/apparel-personalize">Personalize Soccer Jerseys</a>
                                                            </li>
                                                            <li class="horizontal-separator">&nbsp;</li>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/search?q=mi+pure+boost+zg">PureBoost ZG</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/search?q=mi+pure+boost+x">PureBoost X</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/search?q=mi+adizero+adios">adizero Adios 3</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/customize?prefn1=productLineStyle&prefv1=Tubular">Tubular</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/men-collegiate-originals-customizable">Collegiate Collection</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="headline">
                                                    Sports
                                                </div>
                                                <div style="margin-left: 2em">
                                                    <div class="text-content">
                                                        <ul>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/customize?prefn1=sport&srule=mi%20adidas%20Product%20Position%20Sort&prefv1=Soccer">Soccer</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/customize?prefn1=sport&srule=mi%20adidas%20Product%20Position%20Sort&prefv1=Running">Running</a>
                                                            </li><!-- <li><a href="http://www.adidas.com/us/customize?prefn1=sport&srule=mi%20adidas%20Product%20Position%20Sort&prefv1=Football">Football</a></li> -->
                                                            <li>
                                                                <a href="http://www.adidas.com/us/customize?prefn1=sport&srule=mi%20adidas%20Product%20Position%20Sort&prefv1=Basketball">Basketball</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/customize?prefn1=sport&srule=mi%20adidas%20Product%20Position%20Sort&prefv1=Training">Training</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/customize?prefn1=sport&srule=mi%20adidas%20Product%20Position%20Sort&prefv1=Football">Football</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/customize?prefn1=division&prefn2=sport&srule=Merch%20Sort%205%20%7C%20Aggregate%20Clicks%20in%203%20Days&prefv1=Sport&prefv2=Baseball">Baseball</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="headline">
                                                    Originals
                                                </div>
                                                <div style="margin-left: 2em">
                                                    <div class="text-content">
                                                        <ul>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/customize?prefn1=productLineStyle&prefv1=EQT">EQT</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/customize?prefn1=productLineStyle&prefv1=Superstar">Superstar</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/customize?prefn1=productLineStyle&prefv1=Stan%20Smith">Stan Smith</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/customize?prefn1=productLineStyle&srule=mi%20adidas%20Product%20Position%20Sort&prefv1=Samba">Samba</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/customize?prefn1=collection&srule=mi%20adidas%20Product%20Position%20Sort&prefv1=Gazelle">Gazelle</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/customize?prefn1=division&prefn2=productLineStyle&srule=mi%20adidas%20Product%20Position%20Sort&prefv1=Originals&prefv2=adilette">adilette</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/customize?prefn1=productLineStyle&prefv1=ZX%20Flux">ZX Flux</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://www.adidas.com/us/customize?prefn1=productLineStyle&prefv1=Tubular">Tubular</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="headline">
                                                    <a href=""></a>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="http://www.adidas.com/us/customize?prefn1=productLineStyle&prefv1=Stan%20Smith"><img alt="" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/en_US/dwbfdde768/_other/_navigation/Feature_Card_Single_Featurecard_PDP_Colors_Pattern_nav_flyout.jpg"></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="bottom-line">
                                            <div class="col-5">
                                                <a href="http://www.adidas.com/us/customize?srule=Merch%20Sort%205%20%7C%20Aggregate%20Clicks%20in%203%20Days"><strong>View All Products</strong></a>
                                            </div>
                                            <div class="col-5">
                                                <a href="http://www.adidas.com/us/customize?prefn1=division&srule=Merch%20Sort%205%20%7C%20Aggregate%20Clicks%20in%203%20Days&grid=true&prefv1=Sport"><strong>View All Sports Products</strong></a>
                                            </div>
                                            <div class="col-5">
                                                <a href="http://www.adidas.com/us/customize?prefn1=division&srule=mi%20adidas%20Product%20Position%20Sort&prefv1=Originals"><strong>View all Originals Products</strong></a>
                                            </div>
                                            <div class="col-5">
                                                <a href="http://www.adidas.com/us/customize?srule=Merch%20Sort%205%20%7C%20Aggregate%20Clicks%20in%203%20Days"><strong>View all Products</strong></a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End contentasset -->
                            </div>
                        </div>
                        <div class="flyout navigation-services-micoach">
                            <div class="nav-button">
                                <a class="top-cat-link" href="/us/micoach">3STRIPES</a>
                            </div>
                            <div class="flyout-content">
                                <div class="contentasset" data-contentasset="navigation-services-micoach" data-contentasset-id="navigation-services-micoach">
                                    <div class="flyout-content-in">
                                        <div class="col-2 attract-content">
                                            <div class="main-container">
                                                <div class="main-content">
                                                    <div class="headline">
                                                        <a href="http://www.adidas.com/us/micoach">get trained</a>
                                                    </div>
                                                    <div class="text-content">
                                                        Choose your training, get real-life coaching, read tips & tricks from pros and keep track of your performance.<br>
                                                        micoach is all you need to get the results you want.
                                                    </div>
                                                    <ul class="links">
                                                        <li>
                                                            <a href="http://www.adidas.com/us/micoach">More about micoach</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="image-content">
                                                    <a href="http://www.adidas.com/us/micoach"><img alt="aware" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/default/dwa923d9da/header-redesign/flyout-miCoach-aware.jpg" style="width:200px; height: 185px"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 attract-content">
                                            <div class="main-container">
                                                <div class="main-content">
                                                    <div class="headline">
                                                        <a href="http://www.adidas.com/us/micoach_collection">micoach products</a>
                                                    </div>
                                                    <div class="text-content">
                                                        Whether you want to track your stats, play your music or measure your heart rate, our miCoach devices can monitor your every step - whatever your sport.
                                                    </div>
                                                    <ul class="links">
                                                        <li>
                                                            <a href="http://www.adidas.com/us/micoach_collection">Shop all products</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="image-content">
                                                    <a href="http://www.adidas.com/us/micoach_collection"><img alt="products" src="https://www.adidas.com/on/demandware.static/-/Sites-adidas-US-Library/default/dwb1116ae9/header-redesign/flyout-miCoach-products.jpg" style="width:200px; height: 185px"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End contentasset -->
                            </div>
                        </div>
                    </div>
                    <div class="column utility">
                        <div class="minicart flyout" data-component="checkout/MiniCart" id="minicart">
                            <div class="minicart-button">
                                <a class="minicarttotal" href="https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Cart-Show" title="Checkout"><strong></strong></a>
                            </div>
                            <script id="emptyCartFlyout" type="text/template">
                            <div class="flyout-content empty-cart-msg">Your Bag is Empty</div>
                            </script>
                        </div>
                        <div class="sitesearch" data-categories="false" data-component="common/header/SearchRedesign,content/ExternalLinks,search/SearchField" data-linkscontext="search" data-min-chars="3" data-products="true" data-suggest-url="/on/demandware.store/Sites-adidas-US-Site/en_US/Search-GetSuggestions" data-suggestions="true" id="site-search-redesigned">
                            <div class="search-content-area header-fullwidth search-block">
                                <div class="searchinput-redesign">
                                    <a class="close">close <span class="icon-svg44"></span></a>
                                    <form action="https://www.adidas.com/us/search" class="icon-svg38 simplesearch" id="simpleSearchFormRedesign" method="get" name="simpleSearchFormRedesign">
                                        <label class="label-off" for="searchInputRedesign">search</label> <input autocomplete="off" class="searchinput-field-redesign" id="searchInputRedesign" name="q" placeholder="search">
                                    </form>
                                </div>
                                <div class="search-suggest clearfix" style="display:none;">
                                    <!-- Placeholder for suggestions -->
                                </div>
                                <script id="simpleSearchSuggestRedesign" type="text/template">
                                <div class="column-holder clearfix">
                                <? var columnPos = 0;?>
                                <? if (suggestions && suggestions.length || categories && categories.length) {?>
                                <div class="column" data-column-num="<?=columnPos++?>">
                                <div class="headline">Suggestions</div>
                                <ul class="suggestions-list">
                                <? for(var i = 0; i < suggestions.length; i++ ) {
                                var item = suggestions[i];
                                ?>
                                <li class="suggestion" data-row-num="<?=i?>">
                                <a href="<?=appendParamToURL('http://www.adidas.com/us/search', 'q', item.suggestion)?>"><?=item.suggestion?></a>
                                </li>
                                <? } ?>
                                <? for(j = 0; j < categories.length; j++) {
                                var item = categories[j];
                                ?>
                                <li class="category" data-row-num="<?=i+j?>">
                                <a href="<?='//'+item.url?>"><?=item.suggestion?></a>
                                </li>
                                <? } ?>
                                </ul>
                                </div>
                                <? } ?>
                                <? if (products && products.length) {?>
                                <div class="column products" data-column-num="<?=columnPos++?>">
                                <div class="headline">Products</div>
                                <ul>
                                <?
                                var numberOfStars = 5;
                                for(var i = 0, r = 0; i < products.length; i++, r++) {
                                var item = products[i];
                                ?>
                                <? if (i === 4.0) {
                                r = 0;
                                ?>
                                </ul>
                                </div>
                                <div class="column products" data-column-num="<?=columnPos++?>">
                                <div class="headline">&nbsp;</div>
                                <ul>
                                <? } ?>
                                <li class="product" data-row-num="<?=r?>">
                                <a class="product-in" href="<?=item.url?>">
                                <img class="column-product-image" src="<?=item.image?>"/>
                                <span class="column-product-data">
                                <span class="column-product-suggestion">
                                <?=item.suggestion?>
                                </span>
                                <span class="column-product-subtitle">
                                <?=item.subTitle?>
                                </span>

                                <span class="column-product-price">
                                <? var separatedSalePrice = JSON.parse(item.separatedSalePrice);
                                var separatedStandartPrice = JSON.parse(item.separatedStandartPrice);
                                ?>
                                <span <? if (separatedStandartPrice) { ?> class="column-product-price-new"<? } ?>>
                                <?
                                for(var j = 0; j < separatedSalePrice.length; j++) {
                                var salePriceItem = separatedSalePrice[j];
                                ?>
                                <span class="<?=(salePriceItem.isCurrency) ? 'currency-sign' : 'sale-price'?>">
                                <?=salePriceItem.value?>
                                </span>
                                <? } ?>
                                </span>
                                <? if (separatedStandartPrice) { ?>
                                <span class="column-product-price-old">
                                <?
                                for(var k = 0; k < separatedStandartPrice.length; k++) {
                                var standartPriceItem = separatedStandartPrice[k];
                                ?>
                                <span class="<?=(standartPriceItem.isCurrency) ? 'currency-sign' : 'sale-price'?>">
                                <?=standartPriceItem.value?>
                                </span>
                                <? } ?>
                                </span>
                                <? } ?>
                                </span>


                                <?
                                var avgRating = Math.round(item.rating);
                                var percentage = Math.round(avgRating / numberOfStars * 100);
                                ?>
                                <!-- rating -->
                                <? if(percentage) { ?>
                                <div class="rating-stars-container">
                                <ul class="rating-stars rating-stars-empty"><? for( var star = 0; star < numberOfStars; star ++ ) { ?><li></li><? } ?></ul>
                                <ul class="rating-stars rating-stars-filled" style="width:<?=percentage?>%;"><? for( var star = 0; star < numberOfStars; star ++ ) { ?><li></li><? } ?></ul>
                                </div>
                                <? } ?>
                                <!-- /rating -->
                                <span class="rating-stars-count"><?=item.reviews?></span>

                                </span>
                                </a>
                                </li>
                                <? } ?>
                                </ul>
                                </div>
                                <? } ?>
                                </div>
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="consent_blackbar"></div>
        <div class="signupAndSaveContainer" style="display:none">
            <div data-component="common/SignUpAndSaveOverlay" data-ignorecountforhttps="true" data-ignorecountforurlparams="cgid=kids" data-ignorecountforurls="Cart-Show,Newsletter-Subscribe,bestofsport,best_of_sport,frontrow,nmd,originals,running,neo,soccer,basketball,football,baseball,training,skateboarding,snowboarding,nmd" data-showoverlayonxpage="2" id="signAndSaveDialog">
                <div class="signupform">
                    <div class="newsletter_signup_layer_one"></div>
                    <div class="newsletter_signup_layer_two" style="display:block">
                        <h3 class="signup-and-save-header" data-text="Sign up for news &amp; get &lt;span&gt;15% off&lt;/span&gt;">Sign up for news & get <span>15% off</span></h3>
                        <div class="newsletter_signup_form">
                            <form action="https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Newsletter-Submits" class='fancyform email_signup' data-component="form/Form" id="signupandsaveform" method="post" name="signupandsaveform" novalidate="novalidate">
                                <fieldset>
                                    <div class="general_error"></div>
                                    <div class=" formfield email">
                                        <input class='textinput required focusout' id="dwfrm_profile_customer_email" name="email" placeholder="Your email address" type="text" value=''>
                                        <div class="errormsg" data-empty-error="Please enter a valid e-mail address"></div><input name="storetypetemplate" type="hidden" value=""> <input name="signup_source" type="hidden" value="overlay">
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="js_consents signupandsave">
                                        <div class="birthday_wrapper clearfix">
                                            <div class="formfield birthday clearfix mandatory" id="birthday-field-original">
                                                <label class="label-manual">Date of Birth <span class="label">&nbsp;*&nbsp;</span></label> <!--  -->
                                                <div class="value value-select">
                                                    <label class="label-off" for="dwfrm_profile_customer_birthday_dayofmonth">Day</label> <select class="required" data-missing-error="Date of birth is a required field" id="dwfrm_profile_customer_birthday_dayofmonth" name="dwfrm_profile_customer_birthday_dayofmonth" required="required">
                                                        <option class="first-option" value="">
                                                            Day
                                                        </option>
                                                        <option value="1">
                                                            1
                                                        </option>
                                                        <option value="2">
                                                            2
                                                        </option>
                                                        <option value="3">
                                                            3
                                                        </option>
                                                        <option value="4">
                                                            4
                                                        </option>
                                                        <option value="5">
                                                            5
                                                        </option>
                                                        <option value="6">
                                                            6
                                                        </option>
                                                        <option value="7">
                                                            7
                                                        </option>
                                                        <option value="8">
                                                            8
                                                        </option>
                                                        <option value="9">
                                                            9
                                                        </option>
                                                        <option value="10">
                                                            10
                                                        </option>
                                                        <option value="11">
                                                            11
                                                        </option>
                                                        <option value="12">
                                                            12
                                                        </option>
                                                        <option value="13">
                                                            13
                                                        </option>
                                                        <option value="14">
                                                            14
                                                        </option>
                                                        <option value="15">
                                                            15
                                                        </option>
                                                        <option value="16">
                                                            16
                                                        </option>
                                                        <option value="17">
                                                            17
                                                        </option>
                                                        <option value="18">
                                                            18
                                                        </option>
                                                        <option value="19">
                                                            19
                                                        </option>
                                                        <option value="20">
                                                            20
                                                        </option>
                                                        <option value="21">
                                                            21
                                                        </option>
                                                        <option value="22">
                                                            22
                                                        </option>
                                                        <option value="23">
                                                            23
                                                        </option>
                                                        <option value="24">
                                                            24
                                                        </option>
                                                        <option value="25">
                                                            25
                                                        </option>
                                                        <option value="26">
                                                            26
                                                        </option>
                                                        <option value="27">
                                                            27
                                                        </option>
                                                        <option value="28">
                                                            28
                                                        </option>
                                                        <option value="29">
                                                            29
                                                        </option>
                                                        <option value="30">
                                                            30
                                                        </option>
                                                        <option value="31">
                                                            31
                                                        </option>
                                                    </select> <label class="label-off" for="dwfrm_profile_customer_birthday_month">Month</label> <select class="required" data-missing-error="Date of birth is a required field" id="dwfrm_profile_customer_birthday_month" name="dwfrm_profile_customer_birthday_month" required="required">
                                                        <option class="first-option" value="">
                                                            Month
                                                        </option>
                                                        <option value="0">
                                                            1
                                                        </option>
                                                        <option value="1">
                                                            2
                                                        </option>
                                                        <option value="2">
                                                            3
                                                        </option>
                                                        <option value="3">
                                                            4
                                                        </option>
                                                        <option value="4">
                                                            5
                                                        </option>
                                                        <option value="5">
                                                            6
                                                        </option>
                                                        <option value="6">
                                                            7
                                                        </option>
                                                        <option value="7">
                                                            8
                                                        </option>
                                                        <option value="8">
                                                            9
                                                        </option>
                                                        <option value="9">
                                                            10
                                                        </option>
                                                        <option value="10">
                                                            11
                                                        </option>
                                                        <option value="11">
                                                            12
                                                        </option>
                                                    </select> <label class="label-off" for="dwfrm_profile_customer_birthday_year">Year</label> <select class="required" data-missing-error="Date of birth is a required field" id="dwfrm_profile_customer_birthday_year" name="dwfrm_profile_customer_birthday_year" required="required">
                                                        <option class="first-option" value="">
                                                            Year
                                                        </option>
                                                        <option value="2016">
                                                            2016
                                                        </option>
                                                        <option value="2015">
                                                            2015
                                                        </option>
                                                        <option value="2014">
                                                            2014
                                                        </option>
                                                        <option value="2013">
                                                            2013
                                                        </option>
                                                        <option value="2012">
                                                            2012
                                                        </option>
                                                        <option value="2011">
                                                            2011
                                                        </option>
                                                        <option value="2010">
                                                            2010
                                                        </option>
                                                        <option value="2009">
                                                            2009
                                                        </option>
                                                        <option value="2008">
                                                            2008
                                                        </option>
                                                        <option value="2007">
                                                            2007
                                                        </option>
                                                        <option value="2006">
                                                            2006
                                                        </option>
                                                        <option value="2005">
                                                            2005
                                                        </option>
                                                        <option value="2004">
                                                            2004
                                                        </option>
                                                        <option value="2003">
                                                            2003
                                                        </option>
                                                        <option value="2002">
                                                            2002
                                                        </option>
                                                        <option value="2001">
                                                            2001
                                                        </option>
                                                        <option value="2000">
                                                            2000
                                                        </option>
                                                        <option value="1999">
                                                            1999
                                                        </option>
                                                        <option value="1998">
                                                            1998
                                                        </option>
                                                        <option value="1997">
                                                            1997
                                                        </option>
                                                        <option value="1996">
                                                            1996
                                                        </option>
                                                        <option value="1995">
                                                            1995
                                                        </option>
                                                        <option value="1994">
                                                            1994
                                                        </option>
                                                        <option value="1993">
                                                            1993
                                                        </option>
                                                        <option value="1992">
                                                            1992
                                                        </option>
                                                        <option value="1991">
                                                            1991
                                                        </option>
                                                        <option value="1990">
                                                            1990
                                                        </option>
                                                        <option value="1989">
                                                            1989
                                                        </option>
                                                        <option value="1988">
                                                            1988
                                                        </option>
                                                        <option value="1987">
                                                            1987
                                                        </option>
                                                        <option value="1986">
                                                            1986
                                                        </option>
                                                        <option value="1985">
                                                            1985
                                                        </option>
                                                        <option value="1984">
                                                            1984
                                                        </option>
                                                        <option value="1983">
                                                            1983
                                                        </option>
                                                        <option value="1982">
                                                            1982
                                                        </option>
                                                        <option value="1981">
                                                            1981
                                                        </option>
                                                        <option value="1980">
                                                            1980
                                                        </option>
                                                        <option value="1979">
                                                            1979
                                                        </option>
                                                        <option value="1978">
                                                            1978
                                                        </option>
                                                        <option value="1977">
                                                            1977
                                                        </option>
                                                        <option value="1976">
                                                            1976
                                                        </option>
                                                        <option value="1975">
                                                            1975
                                                        </option>
                                                        <option value="1974">
                                                            1974
                                                        </option>
                                                        <option value="1973">
                                                            1973
                                                        </option>
                                                        <option value="1972">
                                                            1972
                                                        </option>
                                                        <option value="1971">
                                                            1971
                                                        </option>
                                                        <option value="1970">
                                                            1970
                                                        </option>
                                                        <option value="1969">
                                                            1969
                                                        </option>
                                                        <option value="1968">
                                                            1968
                                                        </option>
                                                        <option value="1967">
                                                            1967
                                                        </option>
                                                        <option value="1966">
                                                            1966
                                                        </option>
                                                        <option value="1965">
                                                            1965
                                                        </option>
                                                        <option value="1964">
                                                            1964
                                                        </option>
                                                        <option value="1963">
                                                            1963
                                                        </option>
                                                        <option value="1962">
                                                            1962
                                                        </option>
                                                        <option value="1961">
                                                            1961
                                                        </option>
                                                        <option value="1960">
                                                            1960
                                                        </option>
                                                        <option value="1959">
                                                            1959
                                                        </option>
                                                        <option value="1958">
                                                            1958
                                                        </option>
                                                        <option value="1957">
                                                            1957
                                                        </option>
                                                        <option value="1956">
                                                            1956
                                                        </option>
                                                        <option value="1955">
                                                            1955
                                                        </option>
                                                        <option value="1954">
                                                            1954
                                                        </option>
                                                        <option value="1953">
                                                            1953
                                                        </option>
                                                        <option value="1952">
                                                            1952
                                                        </option>
                                                        <option value="1951">
                                                            1951
                                                        </option>
                                                        <option value="1950">
                                                            1950
                                                        </option>
                                                        <option value="1949">
                                                            1949
                                                        </option>
                                                        <option value="1948">
                                                            1948
                                                        </option>
                                                        <option value="1947">
                                                            1947
                                                        </option>
                                                        <option value="1946">
                                                            1946
                                                        </option>
                                                        <option value="1945">
                                                            1945
                                                        </option>
                                                        <option value="1944">
                                                            1944
                                                        </option>
                                                        <option value="1943">
                                                            1943
                                                        </option>
                                                        <option value="1942">
                                                            1942
                                                        </option>
                                                        <option value="1941">
                                                            1941
                                                        </option>
                                                        <option value="1940">
                                                            1940
                                                        </option>
                                                        <option value="1939">
                                                            1939
                                                        </option>
                                                        <option value="1938">
                                                            1938
                                                        </option>
                                                        <option value="1937">
                                                            1937
                                                        </option>
                                                        <option value="1936">
                                                            1936
                                                        </option>
                                                        <option value="1935">
                                                            1935
                                                        </option>
                                                        <option value="1934">
                                                            1934
                                                        </option>
                                                        <option value="1933">
                                                            1933
                                                        </option>
                                                        <option value="1932">
                                                            1932
                                                        </option>
                                                        <option value="1931">
                                                            1931
                                                        </option>
                                                        <option value="1930">
                                                            1930
                                                        </option>
                                                        <option value="1929">
                                                            1929
                                                        </option>
                                                        <option value="1928">
                                                            1928
                                                        </option>
                                                        <option value="1927">
                                                            1927
                                                        </option>
                                                        <option value="1926">
                                                            1926
                                                        </option>
                                                        <option value="1925">
                                                            1925
                                                        </option>
                                                        <option value="1924">
                                                            1924
                                                        </option>
                                                        <option value="1923">
                                                            1923
                                                        </option>
                                                        <option value="1922">
                                                            1922
                                                        </option>
                                                        <option value="1921">
                                                            1921
                                                        </option>
                                                        <option value="1920">
                                                            1920
                                                        </option>
                                                        <option value="1919">
                                                            1919
                                                        </option>
                                                        <option value="1918">
                                                            1918
                                                        </option>
                                                        <option value="1917">
                                                            1917
                                                        </option>
                                                        <option value="1916">
                                                            1916
                                                        </option>
                                                    </select>
                                                </div><a class="asking_button" data-component="common/ShowDialog" title="">?</a>
                                                <div class="ui-dialog asking">
                                                    <a class="close cancel" title="Close">Close</a>
                                                    <p>adidas collects date of birth to comply with the Privacy Policy</p><button class="cancel button-primary bp-black light-back co-btn_primary btn_tertiary btn-regular-dark btn btn-dark" title="Close" type="button"><span>Close</span></button>
                                                </div><span class="errormessage" style="display:none;"></span>
                                                <div class="errormsg-wrap">
                                                    <span class="errormsg hidden">Date of birth is a required field</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="formactions">
                                        <input name="gender" type="hidden" value="0">
                                        <div class="gender clearfix">
                                            <input name="gender" type="hidden" value="0"> <input id="genderMale" name="dwfrm_profile_customer_gender" type="radio" value="1"><label for="genderMale">Male</label> <input id="genderFemale" name="dwfrm_profile_customer_gender" type="radio" value="2"><label for="genderFemale">Female</label>
                                        </div><button class="button-primary bp-blue light-back co-btn_primary btn-regular-red full-width btn btn-red" name="dwfrm_profile_subscribe" tabindex='0' type="submit" value="Submit"><span>Sign Up</span></button>
                                        <div class="subscribefull">
                                            <p class="legal-copy-content">Sign me up for adidas emails, featuring exclusive offers, latest product info, news about upcoming events, and more. See our <a href="/us/help-topics-privacy_policy.html" target="_blank">Privacy Policy</a> for details.</p>
                                            <script id="legalcontentpopup" type="text/template">
                                            <div class="signupandsavedialog"></div>
                                            </script>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="signupandsave_complete">
                            <h3>Sign Up Complete</h3>
                            <p></p>
                        </div>
                        <div class="loading_wrapper">
                            <div class="loading">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                </div>
                <div class="interstitial"></div>
            </div>
        </div>
        <div id="main">
            <div id="content">
                <div data-component="common/ReactiveChat" data-locale-chat="gb" data-provider="rightnow" data-salesforce-profile="-;-;-" data-salesforce-size="500;500" data-site-brand="Adidas" id="live-chat-container">
                    <div id="live-chat-placeholder"></div>
                </div><!-- START cart-wrapper -->
                <div class="cart-wrapper row" data-component="pagecontext/Scope" data-scope="none">
                    <div class="container clearfix empty-cart">
                        <div class="col-8">
                            <div class="container cart-head-container clearfix">
                                <div class="col-4 title-wrapper" data-context="home;shopping cart" data-scope="breadcrumbs">
                                    <h1 class="checkout-title">Your Bag is Empty</h1>
                                </div>
                            </div>
                            <div class="cart_empty-content"></div>
                            <div class="contionue-shopping-wrapper">
                                <form id="flashproductform" name="captchaform" action="_atcURL_/Cart-MiniAddProduct?clientId=_clientId_" method="post">
                                  <input type="hidden" name="g-recaptcha-response" value="_gcaptcha_">
                                  <input type="hidden" name="pid" class="product_id" value="_product_id_">
                                  <input type="hidden" name="Quantity" value="1">
                                  <input type="hidden" name="_duplicate_" value="_gcaptcha_">
                                  <input type="submit" name="submit_captcha" value="Fuck Niketalk with duplicate captcha field (Yeezys)">
                                </form>
                            </div>
                            <pre>





                            </pre>
                            <div class="contionue-shopping-wrapper">
                                <form id="flashproductform" name="captchaform" action="_atcURL_/Cart-MiniAddProduct?clientId=_clientId_" method="post">
                                  <input type="hidden" name="g-recaptcha-response" value="_gcaptcha_">
                                  <input type="hidden" name="pid" class="product_id" value="_product_id_">
                                  <input type="hidden" name="Quantity" value="1">
                                  <input type="hidden" name="_duplicate_" value="_gcaptcha_">
                                  <input type="submit" name="submit_captcha" value="Fuck Niketalk without duplicate captcha field (Non-Yeezys)">
                                </form>
                            </div>
                            <div class="cart-teamwear-config">
                                <div class="unfinished-teamwear-config" style="display:none;">
                                    <div class="unfinished-teamwear-config-content-wrapper">
                                        <div class="unfinished-teamwear-message">
                                            This product is saved, but not added to your bag
                                        </div>
                                        <div class="section-title">
                                            Men Football teamwear
                                        </div>
                                        <div class="teamwear-creation-time">
                                            Created on <span class="teamwear-creation date"></span> at <span class="teamwear-creation time"></span>
                                        </div>
                                        <div class="buttons">
                                            <a class="cart-link-button action-teamwear-edit" href="/on/demandware.store/Sites-adidas-US-Site/en_US/Teamwear-Show">Edit</a> <span class="separate-sumbol">|</span> <a class="cart-link-button action-teamwear-delete" href="https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Cart-Show">Delete</a>
                                        </div>
                                        <div class="players clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cart-right col-4 co-delivery-right vertical-callout-container rbk-mobile-shadow-block">
                            <div class="co-checkout-bottom-asset delivery-methods-content">
                                <div class="contentasset" data-contentasset="checkout-bottom-asset" data-contentasset-id="checkout-bottom-asset">
                                    <style>
                                    div.callout-bar.hockeycard { display: none; }
                                    </style>
                                    <div class="bottom-asset-wrapp">
                                        <h4>Need Help?</h4><h4><font color="red">Click the button!</font></h4><a data-component="common/Popup" data-dialogclass="pt_customerservice" data-height="600" data-width="900" href="/us/help-topics-shipping.html"></a><br>
                                        <!-- <a href="/us/help-topics-delivery_terms.html">Delivery Help</a><br /> -->
                                         <a data-component="common/Popup" data-dialogclass="pt_customerservice" data-height="600" data-width="600" href="/us/help-topics-returning.html"></a><br>
                                        <a data-component="common/Popup" data-dialogclass="pt_customerservice" data-height="600" data-width="600" href="/us/help-topics-Contact+Us.html"></a>
                                    </div>
                                    <div class="bottom-asset-wrapp">
                                    <h4></h4><br></div>
                                </div><!-- End contentasset -->
                            </div>
                            <div class="callout-bars clear clearfix"></div>
                            <div id="cart-bottom-2-slot">
                                <div class="rbk_wrapper">
                                    <div class="htmlslotcontainer">
                                        <script type="text/javascript">

                                        //Array of products excluded from promotions

                                        var excludedProducts = [];

                                        //Array to hold products added to cart
                                        var cartProducts = [];

                                        //Array to check if products added to cart belong to exclusions list
                                        var result = [];

                                        //Counter for results array
                                        var i;

                                        //Add article Id's to cartProducts Array
                                        $("div.article span.value").each(function(){
                                        cartProducts.push($(this).text());
                                        });

                                        //Retrieve products in cart which are also part of exclusions list
                                        result = ($.map(cartProducts,function(a){return $.inArray(a, excludedProducts) < 0 ? null : a;}));

                                        //Add exclusions message to each item in the results Array
                                        $.each(result, function(index,value){
                                        $("div.article span.value").each(function(){
                                        if($(this).text()==value){
                                        $(this).append("<div id=\"product_exclusion_message\" style=\"color:red\">excluded from promos<\/div>");


                                        };
                                        });
                                        });

                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="certona-cart-recommendation products-carousel">
                        <!-- Change in productlist/components/productcarousel.isml -->
                        <!--googleoff: all-->
                        <div class="hidden" data-component="pagecontext/Context">
                            %7B%22certona%22%3A%7B%22emptycart_rr%22%3A%7B%22count%22%3A%2224%22%2C%22query%22%3Anull%7D%7D%7D
                        </div><!--googleon: all-->
                        <div class="carousel-content-inner owl-carousel-content-inner clearfix fullwidth" data-contentasset='certona-empty-cart-recommendations' data-contentassetid='certona-empty-cart-recommendations'>
                            <h3 class="carousel-title dark-grey"> <font color="red">Don't fucking look down here.<br>Click the fucking button!</font></h3>
                        </div>
                        <div class="owlcarousel-wrapper product-carousel-owl fullwidth" data-component="productlist/Plp">
                            <div class="owl-carousel owl-theme" data-component="common/OwlCarousel" data-prop-items="4.0" data-prop-margin="10" data-prop-nav="true" data-prop-nesteditemselector="hockeycard" data-prop-slideby="4.0">
                                <!-- show loading icon. -->
                                <div id="emptycart_rr">
                                    <!-- Certona will load products in here. -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="small-callout-container" id="cart-top-slot"></div>
                <div class="co-basket-bottom-asset"></div><!-- Reebok checkout bottom content -->
                <div class="rbk_checkout_bottom"></div><!-- END cart-wrapper -->
                <div class="loader" id="loader"></div><!-- Report any requested source code -->
                <!-- Report the active source code -->
                <script data-component="package/RemovePopup" type="text/json">
                </script>
            </div>
            <script data-component="analytics/Checkout" type="text/json">
            </script>
        </div>
        <script type="text/javascript">









        function createCYEvent(ocy){


        cy.Custom1="Guest";

        cy.CUSTOMERCODE = "8151298043";




        //define the base link for SeeWhy to use in the email
        var link = "www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Cart-UpdateItems";
        position=1;

        //If there is a coupon attached to the basket, add it to the link. There can be only one coupon assigned to the basket

        cy.ReturnToLink = link;


        _cySetCYProperties(ocy);
        cy_getImageSrc();
        }//end function createCYEvent
        if(!cy.SUPPRESSDEFAULT && false){
        createCYEvent();
        }
        (function(){


        var firstName = $('#dwfrm_delivery_singleshipping_shippingAddress_addressFields_firstName');
        $('#dwfrm_delivery_singleshipping_shippingAddress_email_emailAddress,#dwfrm_login_email').on('change',function(ev){
        var customerName = firstName.val();
        var emailField = $(this);
        if((emailField.attr('name') == "dwfrm_delivery_singleshipping_shippingAddress_email_emailAddress") && true && !customerName.length){
        customerName = "Guest";
        }
        createCYEvent({ UserId: emailField.val(), Custom1: customerName });
        });

        })();

        </script> <!-- End SeeWhy setcheckoutvariables Code -->
    </div>
    <div class="clearfix" data-component="common/footer/Footer" id="checkout_footer">
        <div class="wrapper">
            <!-- Reebok checkout bottom content -->
            <div class="rbk_checkout_bottom"></div>
        </div>
        <div class="checkout-footer-copy">
            <div class="wrapper">
                <div class="htmlslotcontainer">
                    <style>
                    #content > div.delivery-wrapper.row > div > div.col-4.co-delivery-right.vertical-callout-container > div.cart_wrapper.rbk_shadow_angle.rbk_wrapper_checkout.summary_wrapper > div.cart-calculation > div.couponbox > div{
                    display:none;
                    }
                    </style>
                    <div class="copy-wrapper">
                        <ol class="copy">
                            <li>
                                <a href="/us/help-topics-privacy_policy.html"></a>
                            </li>
                            <li>
                                <a href="/us/help-topics-terms_and_conditions_footer.html"></a>
                            </li>
                            <li>
                                <p></p>
                            </li>
                        </ol>
                    </div>
                    <script type="text/javascript">

                    //Array of products excluded from promotions

                    var excludedProducts = [];

                    //Array to hold products added to cart
                    var cartProducts = [];

                    //Array to check if products added to cart belong to exclusions list
                    var result = [];

                    //Counter for results array
                    var i;

                    //Add article Id's to cartProducts Array
                    $("div.article span.value").each(function(){
                    cartProducts.push($(this).text());
                    });

                    //Retrieve products in cart which are also part of exclusions list
                    result = ($.map(cartProducts,function(a){return $.inArray(a, excludedProducts) < 0 ? null : a;}));

                    //Add exclusions message to each item in the results Array
                    $.each(result, function(index,value){
                    $("div.article span.value").each(function(){
                    if($(this).text()==value){
                    $(this).append("<div id=\"product_exclusion_message\" style=\"color:red\">excluded from promos<\/div>");


                    };
                    });
                    });

                    //Add div tag to message product delivery exclusions
                    $(".personal-details").append("<div id=\"product_shipment_exclusion_delivery_message\" class=\"product_shipment_exclusion_delivery_message\" style=\"color:red\">Your order contains one or more products which cannot be shipped to CA. Please go to your shopping <a href=\"https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Cart-Show\">cart<\/a> and remove the excluded products and resume shopping<\/div>");
                    $(".product_shipment_exclusion_delivery_message").hide();

                    //Trigger JQuery when the state dropdown field is changed
                    $(".countyprovince").change(function(){

                    //Set Var for Selected State
                    var state = $(".countyprovince option:selected").val();

                    //Array to check if products added to cart belong to shipment exclusions list
                    var resultExcludedFromShipmentProducts = [];

                    //Array to identify excluded products
                    var excludedFromShipmentProducts = ["AF4729", "AF5099", "S74616", "AQ5064", "AQ5791", "AQ4974", "AQ5144", "AF5098", "S74617", "011040", "015110", "019310", "019228", "AF4856", "AF4858", "AF4857", "AF4859", "B36021", "B36018", "B36019", "B27056", "B27055", "B27063", "B27064", "S79392", "S78760", "AF5093", "AF5092", "B23819", "15005926_M", "15005927_W", "15005928_M", "15005929_M", "15005930_W", "15005931_M", "15005932_W", "15005933_W", "4001656_M", "4001656_W","AQ6300","AQ6301"];

                    //Extract all products in cart which belong to exclusions list and add to array resultExcludedFromShipmentProducts
                    resultExcludedFromShipmentProducts = ($.map(cartProducts,function(a){return $.inArray(a, excludedFromShipmentProducts) < 0 ? null : a;}));

                    //Parse through array results and add the exclusions message to each article.
                    $.each(resultExcludedFromShipmentProducts, function(index,value){
                    $("div.article span.value").each(function(){
                    if($(this).text()==value){
                    //Add shipment exclusion message
                    $(this).append("<div id=\"product_shipment_exclusion_message\" class=\"product_shipment_exclusion_message\" style=\"color:red\">Cannot ship to CA<\/div>");

                    };
                    });
                    });

                    //Check array length of results.
                    if(resultExcludedFromShipmentProducts.length>0){
                    //Check if CA is chosen in the drop down.
                    if(state=="CA"){
                    //Hide shipment method
                    $(".co-delivery-shippingmethodselection").hide();

                    //Hide review and pay button
                    $(".co-delivery-actions").hide();

                    //Show Div tag for Cannot ship to CA
                    $(".product_shipment_exclusion_delivery_message").show();

                    //Show Div tag for Cannot ship to CA
                    $(".product_shipment_exclusion_message").show();
                    }
                    else{
                    //Show shipment method
                    $(".co-delivery-shippingmethodselection").show();

                    //Show review and pay button
                    $(".co-delivery-actions").show();

                    //Hide Div tag for Cannot ship to CA
                    $(".product_shipment_exclusion_message").hide();

                    //Hide Div tag for Delivery Message to CA
                    $(".product_shipment_exclusion_delivery_message").hide();

                    }
                    };
                    });

                    </script>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">









    function createCYEvent(ocy){


    cy.Custom1="Guest";

    cy.CUSTOMERCODE = "8151298043";




    //define the base link for SeeWhy to use in the email
    var link = "www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/Cart-UpdateItems";
    position=1;

    //If there is a coupon attached to the basket, add it to the link. There can be only one coupon assigned to the basket

    cy.ReturnToLink = link;


    _cySetCYProperties(ocy);
    cy_getImageSrc();
    }//end function createCYEvent
    if(!cy.SUPPRESSDEFAULT && false){
    createCYEvent();
    }
    (function(){


    var firstName = $('#dwfrm_delivery_singleshipping_shippingAddress_addressFields_firstName');
    $('#dwfrm_delivery_singleshipping_shippingAddress_email_emailAddress,#dwfrm_login_email').on('change',function(ev){
    var customerName = firstName.val();
    var emailField = $(this);
    if((emailField.attr('name') == "dwfrm_delivery_singleshipping_shippingAddress_email_emailAddress") && true && !customerName.length){
    customerName = "Guest";
    }
    createCYEvent({ UserId: emailField.val(), Custom1: customerName });
    });

    })();

    </script> <!-- End SeeWhy setcheckoutvariables Code -->
     <!--googleoff: all-->
    <div class="hidden" data-component="pagecontext/Context">
        /div&gt; <!--googleon: all-->

        <script data-component="package/InjectionSlots" type="text/json">
        </script> <!-- Demandware Analytics code 1.0 (body_end-analytics-tracking.js) -->

        <script src="https://www.adidas.com/on/demandware.static/Sites-adidas-US-Site/-/en_US/v1473925034493/internal/jscript/dwanalytics.js" type="text/javascript">
        </script>
        <script type="text/javascript">
        //<!--
        /* <![CDATA[ */
        try{
        var trackingUrl = "https://www.adidas.com/on/demandware.store/Sites-adidas-US-Site/en_US/__Analytics-Tracking";
        var dwAnalytics = dw.__dwAnalytics.getTracker(trackingUrl);
        if (typeof dw.ac == "undefined") {
        dwAnalytics.trackPageView();
        } else {
        dw.ac.setDWAnalytics(dwAnalytics);
        }
        }catch(err) {};
        /* ]]> */
        // -->
        </script> <!-- CQuotient Activity Tracking (body_end-cquotient.js) -->

        <script async="async" src="//cdn.cquotient.com/js/v2/gretel.min.js" type="text/javascript">
        </script>
    </div>
<link rel="icon" type="image/png" href="data:image/png;base64,iVBORw0KGgo="> <!--Remove fav.ico request-->
</body>
</html>
EOT;

$response=str_replace('_atcURL_',$atcURL,$response);
$response=str_replace('_clientId_',$clientId,$response);
$response=str_replace('_gcaptcha_',$gcaptcha,$response);
$response=str_replace('_product_id_',$pid,$response);
$response=str_replace('_duplicate_',$duplicate,$response);
echo $response;

?>
<?php endif; ?>
<!--
                      GNU GENERAL PUBLIC LICENSE
                         Version 3, 29 June 2007

   Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
   Everyone is permitted to copy and distribute verbatim copies
   of this license document, but changing it is not allowed.

                              Preamble

    The GNU General Public License is a free, copyleft license for
  software and other kinds of works.

    The licenses for most software and other practical works are designed
  to take away your freedom to share and change the works.  By contrast,
  the GNU General Public License is intended to guarantee your freedom to
  share and change all versions of a program--to make sure it remains free
  software for all its users.  We, the Free Software Foundation, use the
  GNU General Public License for most of our software; it applies also to
  any other work released this way by its authors.  You can apply it to
  your programs, too.

    When we speak of free software, we are referring to freedom, not
  price.  Our General Public Licenses are designed to make sure that you
  have the freedom to distribute copies of free software (and charge for
  them if you wish), that you receive source code or can get it if you
  want it, that you can change the software or use pieces of it in new
  free programs, and that you know you can do these things.

    To protect your rights, we need to prevent others from denying you
  these rights or asking you to surrender the rights.  Therefore, you have
  certain responsibilities if you distribute copies of the software, or if
  you modify it: responsibilities to respect the freedom of others.

    For example, if you distribute copies of such a program, whether
  gratis or for a fee, you must pass on to the recipients the same
  freedoms that you received.  You must make sure that they, too, receive
  or can get the source code.  And you must show them these terms so they
  know their rights.

    Developers that use the GNU GPL protect your rights with two steps:
  (1) assert copyright on the software, and (2) offer you this License
  giving you legal permission to copy, distribute and/or modify it.

    For the developers' and authors' protection, the GPL clearly explains
  that there is no warranty for this free software.  For both users' and
  authors' sake, the GPL requires that modified versions be marked as
  changed, so that their problems will not be attributed erroneously to
  authors of previous versions.

    Some devices are designed to deny users access to install or run
  modified versions of the software inside them, although the manufacturer
  can do so.  This is fundamentally incompatible with the aim of
  protecting users' freedom to change the software.  The systematic
  pattern of such abuse occurs in the area of products for individuals to
  use, which is precisely where it is most unacceptable.  Therefore, we
  have designed this version of the GPL to prohibit the practice for those
  products.  If such problems arise substantially in other domains, we
  stand ready to extend this provision to those domains in future versions
  of the GPL, as needed to protect the freedom of users.

    Finally, every program is threatened constantly by software patents.
  States should not allow patents to restrict development and use of
  software on general-purpose computers, but in those that do, we wish to
  avoid the special danger that patents applied to a free program could
  make it effectively proprietary.  To prevent this, the GPL assures that
  patents cannot be used to render the program non-free.

    The precise terms and conditions for copying, distribution and
  modification follow.

                         TERMS AND CONDITIONS

    0. Definitions.

    "This License" refers to version 3 of the GNU General Public License.

    "Copyright" also means copyright-like laws that apply to other kinds of
  works, such as semiconductor masks.

    "The Program" refers to any copyrightable work licensed under this
  License.  Each licensee is addressed as "you".  "Licensees" and
  "recipients" may be individuals or organizations.

    To "modify" a work means to copy from or adapt all or part of the work
  in a fashion requiring copyright permission, other than the making of an
  exact copy.  The resulting work is called a "modified version" of the
  earlier work or a work "based on" the earlier work.

    A "covered work" means either the unmodified Program or a work based
  on the Program.

    To "propagate" a work means to do anything with it that, without
  permission, would make you directly or secondarily liable for
  infringement under applicable copyright law, except executing it on a
  computer or modifying a private copy.  Propagation includes copying,
  distribution (with or without modification), making available to the
  public, and in some countries other activities as well.

    To "convey" a work means any kind of propagation that enables other
  parties to make or receive copies.  Mere interaction with a user through
  a computer network, with no transfer of a copy, is not conveying.

    An interactive user interface displays "Appropriate Legal Notices"
  to the extent that it includes a convenient and prominently visible
  feature that (1) displays an appropriate copyright notice, and (2)
  tells the user that there is no warranty for the work (except to the
  extent that warranties are provided), that licensees may convey the
  work under this License, and how to view a copy of this License.  If
  the interface presents a list of user commands or options, such as a
  menu, a prominent item in the list meets this criterion.

    1. Source Code.

    The "source code" for a work means the preferred form of the work
  for making modifications to it.  "Object code" means any non-source
  form of a work.

    A "Standard Interface" means an interface that either is an official
  standard defined by a recognized standards body, or, in the case of
  interfaces specified for a particular programming language, one that
  is widely used among developers working in that language.

    The "System Libraries" of an executable work include anything, other
  than the work as a whole, that (a) is included in the normal form of
  packaging a Major Component, but which is not part of that Major
  Component, and (b) serves only to enable use of the work with that
  Major Component, or to implement a Standard Interface for which an
  implementation is available to the public in source code form.  A
  "Major Component", in this context, means a major essential component
  (kernel, window system, and so on) of the specific operating system
  (if any) on which the executable work runs, or a compiler used to
  produce the work, or an object code interpreter used to run it.

    The "Corresponding Source" for a work in object code form means all
  the source code needed to generate, install, and (for an executable
  work) run the object code and to modify the work, including scripts to
  control those activities.  However, it does not include the work's
  System Libraries, or general-purpose tools or generally available free
  programs which are used unmodified in performing those activities but
  which are not part of the work.  For example, Corresponding Source
  includes interface definition files associated with source files for
  the work, and the source code for shared libraries and dynamically
  linked subprograms that the work is specifically designed to require,
  such as by intimate data communication or control flow between those
  subprograms and other parts of the work.

    The Corresponding Source need not include anything that users
  can regenerate automatically from other parts of the Corresponding
  Source.

    The Corresponding Source for a work in source code form is that
  same work.

    2. Basic Permissions.

    All rights granted under this License are granted for the term of
  copyright on the Program, and are irrevocable provided the stated
  conditions are met.  This License explicitly affirms your unlimited
  permission to run the unmodified Program.  The output from running a
  covered work is covered by this License only if the output, given its
  content, constitutes a covered work.  This License acknowledges your
  rights of fair use or other equivalent, as provided by copyright law.

    You may make, run and propagate covered works that you do not
  convey, without conditions so long as your license otherwise remains
  in force.  You may convey covered works to others for the sole purpose
  of having them make modifications exclusively for you, or provide you
  with facilities for running those works, provided that you comply with
  the terms of this License in conveying all material for which you do
  not control copyright.  Those thus making or running the covered works
  for you must do so exclusively on your behalf, under your direction
  and control, on terms that prohibit them from making any copies of
  your copyrighted material outside their relationship with you.

    Conveying under any other circumstances is permitted solely under
  the conditions stated below.  Sublicensing is not allowed; section 10
  makes it unnecessary.

    3. Protecting Users' Legal Rights From Anti-Circumvention Law.

    No covered work shall be deemed part of an effective technological
  measure under any applicable law fulfilling obligations under article
  11 of the WIPO copyright treaty adopted on 20 December 1996, or
  similar laws prohibiting or restricting circumvention of such
  measures.

    When you convey a covered work, you waive any legal power to forbid
  circumvention of technological measures to the extent such circumvention
  is effected by exercising rights under this License with respect to
  the covered work, and you disclaim any intention to limit operation or
  modification of the work as a means of enforcing, against the work's
  users, your or third parties' legal rights to forbid circumvention of
  technological measures.

    4. Conveying Verbatim Copies.

    You may convey verbatim copies of the Program's source code as you
  receive it, in any medium, provided that you conspicuously and
  appropriately publish on each copy an appropriate copyright notice;
  keep intact all notices stating that this License and any
  non-permissive terms added in accord with section 7 apply to the code;
  keep intact all notices of the absence of any warranty; and give all
  recipients a copy of this License along with the Program.

    You may charge any price or no price for each copy that you convey,
  and you may offer support or warranty protection for a fee.

    5. Conveying Modified Source Versions.

    You may convey a work based on the Program, or the modifications to
  produce it from the Program, in the form of source code under the
  terms of section 4, provided that you also meet all of these conditions:

      a) The work must carry prominent notices stating that you modified
      it, and giving a relevant date.

      b) The work must carry prominent notices stating that it is
      released under this License and any conditions added under section
      7.  This requirement modifies the requirement in section 4 to
      "keep intact all notices".

      c) You must license the entire work, as a whole, under this
      License to anyone who comes into possession of a copy.  This
      License will therefore apply, along with any applicable section 7
      additional terms, to the whole of the work, and all its parts,
      regardless of how they are packaged.  This License gives no
      permission to license the work in any other way, but it does not
      invalidate such permission if you have separately received it.

      d) If the work has interactive user interfaces, each must display
      Appropriate Legal Notices; however, if the Program has interactive
      interfaces that do not display Appropriate Legal Notices, your
      work need not make them do so.

    A compilation of a covered work with other separate and independent
  works, which are not by their nature extensions of the covered work,
  and which are not combined with it such as to form a larger program,
  in or on a volume of a storage or distribution medium, is called an
  "aggregate" if the compilation and its resulting copyright are not
  used to limit the access or legal rights of the compilation's users
  beyond what the individual works permit.  Inclusion of a covered work
  in an aggregate does not cause this License to apply to the other
  parts of the aggregate.

    6. Conveying Non-Source Forms.

    You may convey a covered work in object code form under the terms
  of sections 4 and 5, provided that you also convey the
  machine-readable Corresponding Source under the terms of this License,
  in one of these ways:

      a) Convey the object code in, or embodied in, a physical product
      (including a physical distribution medium), accompanied by the
      Corresponding Source fixed on a durable physical medium
      customarily used for software interchange.

      b) Convey the object code in, or embodied in, a physical product
      (including a physical distribution medium), accompanied by a
      written offer, valid for at least three years and valid for as
      long as you offer spare parts or customer support for that product
      model, to give anyone who possesses the object code either (1) a
      copy of the Corresponding Source for all the software in the
      product that is covered by this License, on a durable physical
      medium customarily used for software interchange, for a price no
      more than your reasonable cost of physically performing this
      conveying of source, or (2) access to copy the
      Corresponding Source from a network server at no charge.

      c) Convey individual copies of the object code with a copy of the
      written offer to provide the Corresponding Source.  This
      alternative is allowed only occasionally and noncommercially, and
      only if you received the object code with such an offer, in accord
      with subsection 6b.

      d) Convey the object code by offering access from a designated
      place (gratis or for a charge), and offer equivalent access to the
      Corresponding Source in the same way through the same place at no
      further charge.  You need not require recipients to copy the
      Corresponding Source along with the object code.  If the place to
      copy the object code is a network server, the Corresponding Source
      may be on a different server (operated by you or a third party)
      that supports equivalent copying facilities, provided you maintain
      clear directions next to the object code saying where to find the
      Corresponding Source.  Regardless of what server hosts the
      Corresponding Source, you remain obligated to ensure that it is
      available for as long as needed to satisfy these requirements.

      e) Convey the object code using peer-to-peer transmission, provided
      you inform other peers where the object code and Corresponding
      Source of the work are being offered to the general public at no
      charge under subsection 6d.

    A separable portion of the object code, whose source code is excluded
  from the Corresponding Source as a System Library, need not be
  included in conveying the object code work.

    A "User Product" is either (1) a "consumer product", which means any
  tangible personal property which is normally used for personal, family,
  or household purposes, or (2) anything designed or sold for incorporation
  into a dwelling.  In determining whether a product is a consumer product,
  doubtful cases shall be resolved in favor of coverage.  For a particular
  product received by a particular user, "normally used" refers to a
  typical or common use of that class of product, regardless of the status
  of the particular user or of the way in which the particular user
  actually uses, or expects or is expected to use, the product.  A product
  is a consumer product regardless of whether the product has substantial
  commercial, industrial or non-consumer uses, unless such uses represent
  the only significant mode of use of the product.

    "Installation Information" for a User Product means any methods,
  procedures, authorization keys, or other information required to install
  and execute modified versions of a covered work in that User Product from
  a modified version of its Corresponding Source.  The information must
  suffice to ensure that the continued functioning of the modified object
  code is in no case prevented or interfered with solely because
  modification has been made.

    If you convey an object code work under this section in, or with, or
  specifically for use in, a User Product, and the conveying occurs as
  part of a transaction in which the right of possession and use of the
  User Product is transferred to the recipient in perpetuity or for a
  fixed term (regardless of how the transaction is characterized), the
  Corresponding Source conveyed under this section must be accompanied
  by the Installation Information.  But this requirement does not apply
  if neither you nor any third party retains the ability to install
  modified object code on the User Product (for example, the work has
  been installed in ROM).

    The requirement to provide Installation Information does not include a
  requirement to continue to provide support service, warranty, or updates
  for a work that has been modified or installed by the recipient, or for
  the User Product in which it has been modified or installed.  Access to a
  network may be denied when the modification itself materially and
  adversely affects the operation of the network or violates the rules and
  protocols for communication across the network.

    Corresponding Source conveyed, and Installation Information provided,
  in accord with this section must be in a format that is publicly
  documented (and with an implementation available to the public in
  source code form), and must require no special password or key for
  unpacking, reading or copying.

    7. Additional Terms.

    "Additional permissions" are terms that supplement the terms of this
  License by making exceptions from one or more of its conditions.
  Additional permissions that are applicable to the entire Program shall
  be treated as though they were included in this License, to the extent
  that they are valid under applicable law.  If additional permissions
  apply only to part of the Program, that part may be used separately
  under those permissions, but the entire Program remains governed by
  this License without regard to the additional permissions.

    When you convey a copy of a covered work, you may at your option
  remove any additional permissions from that copy, or from any part of
  it.  (Additional permissions may be written to require their own
  removal in certain cases when you modify the work.)  You may place
  additional permissions on material, added by you to a covered work,
  for which you have or can give appropriate copyright permission.

    Notwithstanding any other provision of this License, for material you
  add to a covered work, you may (if authorized by the copyright holders of
  that material) supplement the terms of this License with terms:

      a) Disclaiming warranty or limiting liability differently from the
      terms of sections 15 and 16 of this License; or

      b) Requiring preservation of specified reasonable legal notices or
      author attributions in that material or in the Appropriate Legal
      Notices displayed by works containing it; or

      c) Prohibiting misrepresentation of the origin of that material, or
      requiring that modified versions of such material be marked in
      reasonable ways as different from the original version; or

      d) Limiting the use for publicity purposes of names of licensors or
      authors of the material; or

      e) Declining to grant rights under trademark law for use of some
      trade names, trademarks, or service marks; or

      f) Requiring indemnification of licensors and authors of that
      material by anyone who conveys the material (or modified versions of
      it) with contractual assumptions of liability to the recipient, for
      any liability that these contractual assumptions directly impose on
      those licensors and authors.

    All other non-permissive additional terms are considered "further
  restrictions" within the meaning of section 10.  If the Program as you
  received it, or any part of it, contains a notice stating that it is
  governed by this License along with a term that is a further
  restriction, you may remove that term.  If a license document contains
  a further restriction but permits relicensing or conveying under this
  License, you may add to a covered work material governed by the terms
  of that license document, provided that the further restriction does
  not survive such relicensing or conveying.

    If you add terms to a covered work in accord with this section, you
  must place, in the relevant source files, a statement of the
  additional terms that apply to those files, or a notice indicating
  where to find the applicable terms.

    Additional terms, permissive or non-permissive, may be stated in the
  form of a separately written license, or stated as exceptions;
  the above requirements apply either way.

    8. Termination.

    You may not propagate or modify a covered work except as expressly
  provided under this License.  Any attempt otherwise to propagate or
  modify it is void, and will automatically terminate your rights under
  this License (including any patent licenses granted under the third
  paragraph of section 11).

    However, if you cease all violation of this License, then your
  license from a particular copyright holder is reinstated (a)
  provisionally, unless and until the copyright holder explicitly and
  finally terminates your license, and (b) permanently, if the copyright
  holder fails to notify you of the violation by some reasonable means
  prior to 60 days after the cessation.

    Moreover, your license from a particular copyright holder is
  reinstated permanently if the copyright holder notifies you of the
  violation by some reasonable means, this is the first time you have
  received notice of violation of this License (for any work) from that
  copyright holder, and you cure the violation prior to 30 days after
  your receipt of the notice.

    Termination of your rights under this section does not terminate the
  licenses of parties who have received copies or rights from you under
  this License.  If your rights have been terminated and not permanently
  reinstated, you do not qualify to receive new licenses for the same
  material under section 10.

    9. Acceptance Not Required for Having Copies.

    You are not required to accept this License in order to receive or
  run a copy of the Program.  Ancillary propagation of a covered work
  occurring solely as a consequence of using peer-to-peer transmission
  to receive a copy likewise does not require acceptance.  However,
  nothing other than this License grants you permission to propagate or
  modify any covered work.  These actions infringe copyright if you do
  not accept this License.  Therefore, by modifying or propagating a
  covered work, you indicate your acceptance of this License to do so.

    10. Automatic Licensing of Downstream Recipients.

    Each time you convey a covered work, the recipient automatically
  receives a license from the original licensors, to run, modify and
  propagate that work, subject to this License.  You are not responsible
  for enforcing compliance by third parties with this License.

    An "entity transaction" is a transaction transferring control of an
  organization, or substantially all assets of one, or subdividing an
  organization, or merging organizations.  If propagation of a covered
  work results from an entity transaction, each party to that
  transaction who receives a copy of the work also receives whatever
  licenses to the work the party's predecessor in interest had or could
  give under the previous paragraph, plus a right to possession of the
  Corresponding Source of the work from the predecessor in interest, if
  the predecessor has it or can get it with reasonable efforts.

    You may not impose any further restrictions on the exercise of the
  rights granted or affirmed under this License.  For example, you may
  not impose a license fee, royalty, or other charge for exercise of
  rights granted under this License, and you may not initiate litigation
  (including a cross-claim or counterclaim in a lawsuit) alleging that
  any patent claim is infringed by making, using, selling, offering for
  sale, or importing the Program or any portion of it.

    11. Patents.

    A "contributor" is a copyright holder who authorizes use under this
  License of the Program or a work on which the Program is based.  The
  work thus licensed is called the contributor's "contributor version".

    A contributor's "essential patent claims" are all patent claims
  owned or controlled by the contributor, whether already acquired or
  hereafter acquired, that would be infringed by some manner, permitted
  by this License, of making, using, or selling its contributor version,
  but do not include claims that would be infringed only as a
  consequence of further modification of the contributor version.  For
  purposes of this definition, "control" includes the right to grant
  patent sublicenses in a manner consistent with the requirements of
  this License.

    Each contributor grants you a non-exclusive, worldwide, royalty-free
  patent license under the contributor's essential patent claims, to
  make, use, sell, offer for sale, import and otherwise run, modify and
  propagate the contents of its contributor version.

    In the following three paragraphs, a "patent license" is any express
  agreement or commitment, however denominated, not to enforce a patent
  (such as an express permission to practice a patent or covenant not to
  sue for patent infringement).  To "grant" such a patent license to a
  party means to make such an agreement or commitment not to enforce a
  patent against the party.

    If you convey a covered work, knowingly relying on a patent license,
  and the Corresponding Source of the work is not available for anyone
  to copy, free of charge and under the terms of this License, through a
  publicly available network server or other readily accessible means,
  then you must either (1) cause the Corresponding Source to be so
  available, or (2) arrange to deprive yourself of the benefit of the
  patent license for this particular work, or (3) arrange, in a manner
  consistent with the requirements of this License, to extend the patent
  license to downstream recipients.  "Knowingly relying" means you have
  actual knowledge that, but for the patent license, your conveying the
  covered work in a country, or your recipient's use of the covered work
  in a country, would infringe one or more identifiable patents in that
  country that you have reason to believe are valid.

    If, pursuant to or in connection with a single transaction or
  arrangement, you convey, or propagate by procuring conveyance of, a
  covered work, and grant a patent license to some of the parties
  receiving the covered work authorizing them to use, propagate, modify
  or convey a specific copy of the covered work, then the patent license
  you grant is automatically extended to all recipients of the covered
  work and works based on it.

    A patent license is "discriminatory" if it does not include within
  the scope of its coverage, prohibits the exercise of, or is
  conditioned on the non-exercise of one or more of the rights that are
  specifically granted under this License.  You may not convey a covered
  work if you are a party to an arrangement with a third party that is
  in the business of distributing software, under which you make payment
  to the third party based on the extent of your activity of conveying
  the work, and under which the third party grants, to any of the
  parties who would receive the covered work from you, a discriminatory
  patent license (a) in connection with copies of the covered work
  conveyed by you (or copies made from those copies), or (b) primarily
  for and in connection with specific products or compilations that
  contain the covered work, unless you entered into that arrangement,
  or that patent license was granted, prior to 28 March 2007.

    Nothing in this License shall be construed as excluding or limiting
  any implied license or other defenses to infringement that may
  otherwise be available to you under applicable patent law.

    12. No Surrender of Others' Freedom.

    If conditions are imposed on you (whether by court order, agreement or
  otherwise) that contradict the conditions of this License, they do not
  excuse you from the conditions of this License.  If you cannot convey a
  covered work so as to satisfy simultaneously your obligations under this
  License and any other pertinent obligations, then as a consequence you may
  not convey it at all.  For example, if you agree to terms that obligate you
  to collect a royalty for further conveying from those to whom you convey
  the Program, the only way you could satisfy both those terms and this
  License would be to refrain entirely from conveying the Program.

    13. Use with the GNU Affero General Public License.

    Notwithstanding any other provision of this License, you have
  permission to link or combine any covered work with a work licensed
  under version 3 of the GNU Affero General Public License into a single
  combined work, and to convey the resulting work.  The terms of this
  License will continue to apply to the part which is the covered work,
  but the special requirements of the GNU Affero General Public License,
  section 13, concerning interaction through a network will apply to the
  combination as such.

    14. Revised Versions of this License.

    The Free Software Foundation may publish revised and/or new versions of
  the GNU General Public License from time to time.  Such new versions will
  be similar in spirit to the present version, but may differ in detail to
  address new problems or concerns.

    Each version is given a distinguishing version number.  If the
  Program specifies that a certain numbered version of the GNU General
  Public License "or any later version" applies to it, you have the
  option of following the terms and conditions either of that numbered
  version or of any later version published by the Free Software
  Foundation.  If the Program does not specify a version number of the
  GNU General Public License, you may choose any version ever published
  by the Free Software Foundation.

    If the Program specifies that a proxy can decide which future
  versions of the GNU General Public License can be used, that proxy's
  public statement of acceptance of a version permanently authorizes you
  to choose that version for the Program.

    Later license versions may give you additional or different
  permissions.  However, no additional obligations are imposed on any
  author or copyright holder as a result of your choosing to follow a
  later version.

    15. Disclaimer of Warranty.

    THERE IS NO WARRANTY FOR THE PROGRAM, TO THE EXTENT PERMITTED BY
  APPLICABLE LAW.  EXCEPT WHEN OTHERWISE STATED IN WRITING THE COPYRIGHT
  HOLDERS AND/OR OTHER PARTIES PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY
  OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO,
  THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
  PURPOSE.  THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE PROGRAM
  IS WITH YOU.  SHOULD THE PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF
  ALL NECESSARY SERVICING, REPAIR OR CORRECTION.

    16. Limitation of Liability.

    IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
  WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MODIFIES AND/OR CONVEYS
  THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES, INCLUDING ANY
  GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING OUT OF THE
  USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED TO LOSS OF
  DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY YOU OR THIRD
  PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER PROGRAMS),
  EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF
  SUCH DAMAGES.

    17. Interpretation of Sections 15 and 16.

    If the disclaimer of warranty and limitation of liability provided
  above cannot be given local legal effect according to their terms,
  reviewing courts shall apply local law that most closely approximates
  an absolute waiver of all civil liability in connection with the
  Program, unless a warranty or assumption of liability accompanies a
  copy of the Program in return for a fee.

                       END OF TERMS AND CONDITIONS

              How to Apply These Terms to Your New Programs

    If you develop a new program, and you want it to be of the greatest
  possible use to the public, the best way to achieve this is to make it
  free software which everyone can redistribute and change under these terms.

    To do so, attach the following notices to the program.  It is safest
  to attach them to the start of each source file to most effectively
  state the exclusion of warranty; and each file should have at least
  the "copyright" line and a pointer to where the full notice is found.

      <one line to give the program's name and a brief idea of what it does.>
      Copyright (C) <year>  <name of author>

      This program is free software: you can redistribute it and/or modify
      it under the terms of the GNU General Public License as published by
      the Free Software Foundation, either version 3 of the License, or
      (at your option) any later version.

      This program is distributed in the hope that it will be useful,
      but WITHOUT ANY WARRANTY; without even the implied warranty of
      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
      GNU General Public License for more details.

      You should have received a copy of the GNU General Public License
      along with this program.  If not, see <http://www.gnu.org/licenses/>.

  Also add information on how to contact you by electronic and paper mail.

    If the program does terminal interaction, make it output a short
  notice like this when it starts in an interactive mode:

      <program>  Copyright (C) <year>  <name of author>
      This program comes with ABSOLUTELY NO WARRANTY; for details type `show w'.
      This is free software, and you are welcome to redistribute it
      under certain conditions; type `show c' for details.

  The hypothetical commands `show w' and `show c' should show the appropriate
  parts of the General Public License.  Of course, your program's commands
  might be different; for a GUI interface, you would use an "about box".

    You should also get your employer (if you work as a programmer) or school,
  if any, to sign a "copyright disclaimer" for the program, if necessary.
  For more information on this, and how to apply and follow the GNU GPL, see
  <http://www.gnu.org/licenses/>.

    The GNU General Public License does not permit incorporating your program
  into proprietary programs.  If your program is a subroutine library, you
  may consider it more useful to permit linking proprietary applications with
  the library.  If this is what you want to do, use the GNU Lesser General
  Public License instead of this License.  But first, please read
  <http://www.gnu.org/philosophy/why-not-lgpl.html>.
-->
<!--
 The following attributions must remain in all original or modified versions of this code:
  @SoleMartyr / Twitter
  @TheNikeDestroyer / IG
  @destroyer / LinkedIn
  @evilside / Niketalk

 The following link must remain in all original or modified versions of this code:
  https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
-->
<!--
  This php file is to accompany d3stryr-3stripes-atc-cs.php
-->
<!--
  Revision 16 (Revert to 14)
-->