<?php
  $keyword = (string)$_POST['data1'];
  $code = (string)$_POST['data2'];
  // $keyword = '청주원룸이사';
  // $code = '1682496774';
  $servername = "db.tmdwns1155.gabia.io";
  $username = "tmdwns1155"; // For MYSQL the predifined username is root
  $password = "tmdwns5458@"; // For MYSQL the predifined password is " "(blank)
  $database_name = "dbtmdwns1155";
  // // Create connection
  $conn = new mysqli($servername, $username, $password, $database_name);
  mysqli_query($conn, "set session character_set_connection=utf8;");
  mysqli_query($conn, "set session character_set_results=utf8;");
  mysqli_query($conn, "set session character_set_client=utf8;");
  //
  // // Check connection
  //
  $sql = "INSERT INTO palce_check (keyword, code) VALUES ('$keyword', '$code')";
  mysqli_query($conn, $sql);
  // if(mysqli_query($conn, $sql)){
  //   echo "";
  //   } else{
  //     echo "";
  //   }
  mysqli_close($conn);
  // $keyword = '강남 미용실';
  // $code = '11737510';

$operations = array(
  'getBeautyList' => array(
    'operationName' => 'getBeautyList',
    'query' => 'query getBeautyList($input: BeautyListInput, $businessType: String, $isNmap: Boolean!, $isBounds: Boolean!) {\n  businesses: hairshops(input: $input) {\n    total\n    items {\n      ...BeautyItemFields\n      imageMarker @include(if: $isNmap) {\n        marker\n        markerSelected\n        __typename\n      }\n      markerLabel @include(if: $isNmap) {\n        text\n        style\n        __typename\n      }\n      __typename\n    }\n    nlu {\n      ...NluFields\n      __typename\n    }\n    optionsForMap @include(if: $isBounds) {\n      maxZoom\n      minZoom\n      includeMyLocation\n      maxIncludePoiCount\n      center\n      __typename\n    }\n    userGender\n    __typename\n  }\n  brands: beautyBrands(input: $input, businessType: $businessType) {\n    name\n    cid\n    __typename\n  }\n}\n\nfragment NluFields on Nlu {\n  queryType\n  user {\n    gender\n    __typename\n  }\n  queryResult {\n    ptn0\n    ptn1\n    region\n    spot\n    tradeName\n    service\n    selectedRegion {\n      name\n      index\n      x\n      y\n      __typename\n    }\n    selectedRegionIndex\n    otherRegions {\n      name\n      index\n      __typename\n    }\n    property\n    keyword\n    queryType\n    nluQuery\n    businessType\n    cid\n    branch\n    franchise\n    titleKeyword\n    location {\n      x\n      y\n      default\n      longitude\n      latitude\n      dong\n      si\n      __typename\n    }\n    noRegionQuery\n    priority\n    showLocationBarFlag\n    themeId\n    filterBooking\n    repRegion\n    repSpot\n    dbQuery {\n      isDefault\n      name\n      type\n      getType\n      useFilter\n      hasComponents\n      __typename\n    }\n    type\n    category\n    menu\n    context\n    __typename\n  }\n  __typename\n}\n\nfragment BeautyItemFields on BeautySummary {\n  id\n  name\n  hasBooking\n  hasNPay\n  hasPostNPay\n  blogCafeReviewCount\n  bookingReviewCount\n  bookingReviewScore\n  description\n  roadAddress\n  address\n  imageUrl\n  talktalkUrl\n  distance\n  x\n  y\n  representativePrice {\n    isFiltered\n    priceName\n    price\n    __typename\n  }\n  nPayPromotions {\n    payPercentage\n    postPaidPercentage\n    __typename\n  }\n  promotionTitle\n  stylesCount\n  styles {\n    desc\n    styleNum\n    isPopular\n    images {\n      imageUrl\n      __typename\n    }\n    styleOptions {\n      num\n      __typename\n    }\n    __typename\n  }\n  visitorReviewCount\n  visitorReviewScore\n  streetPanorama {\n    id\n    pan\n    tilt\n    lat\n    lon\n    __typename\n  }\n  styleBookingCounts {\n    styleNum\n    name\n    count\n    isPopular\n    __typename\n  }\n  __typename\n}\n',
    'variables' => array(
      'businessType' => 'hairshop',
      'input' => array(
        'deviceType'    => 'pcmap',
        'display'       => 50, // 검색결과수
        'filterBooking' => false,
        'naverBenefit'  => false,
        'query'         => '강남 미용실', // 검색어
        'sortingOrder'  => 'precision',
        'start'         => 1, // 첫 페이지, 두 번째 페이지는 51 ...
        'x'             => '127.01396942138707', // x 좌표
        'y'             => '37.51728291676506',  // y 좌표
      ),
      'isBounds' => true,
      'isNmap' => false
    )
  ),

  'getRestaurants' => array(
    'operationName' => 'getRestaurants',
    'query' => 'query getRestaurants($input: RestaurantsInput, $isNmap: Boolean!, $isBounds: Boolean!) {\n  restaurants(input: $input) {\n    total\n    items {\n      ...RestaurantItemFields\n      easyOrder {\n        easyOrderId\n        easyOrderCid\n        businessHours {\n          weekday {\n            start\n            end\n            __typename\n          }\n          weekend {\n            start\n            end\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      baemin {\n        businessHours {\n          deliveryTime {\n            start\n            end\n            __typename\n          }\n          closeDate {\n            start\n            end\n            __typename\n          }\n          temporaryCloseDate {\n            start\n            end\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      yogiyo {\n        businessHours {\n          actualDeliveryTime {\n            start\n            end\n            __typename\n          }\n          bizHours {\n            start\n            end\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      __typename\n    }\n    nlu {\n      ...NluFields\n      __typename\n    }\n    brand {\n      name\n      isBrand\n      type\n      menus {\n        order\n        id\n        images {\n          url\n          desc\n          __typename\n        }\n        name\n        desc\n        price\n        isRepresentative\n        detailUrl\n        orderType\n        catalogId\n        source\n        menuId\n        nutrients\n        allergies\n        __typename\n      }\n      __typename\n    }\n    optionsForMap @include(if: $isBounds) {\n      maxZoom\n      minZoom\n      includeMyLocation\n      maxIncludePoiCount\n      center\n      spotId\n      __typename\n    }\n    __typename\n  }\n}\n\nfragment RestaurantItemFields on RestaurantSummary {\n  id\n  dbType\n  name\n  businessCategory\n  category\n  description\n  hasBooking\n  hasNPay\n  x\n  y\n  distance\n  imageUrl\n  imageUrls\n  imageCount\n  phone\n  virtualPhone\n  routeUrl\n  streetPanorama {\n    id\n    pan\n    tilt\n    lat\n    lon\n    __typename\n  }\n  roadAddress\n  address\n  commonAddress\n  blogCafeReviewCount\n  bookingReviewCount\n  totalReviewCount\n  bookingReviewScore\n  bookingUrl\n  bookingHubUrl\n  bookingHubButtonName\n  bookingBusinessId\n  talktalkUrl\n  options\n  promotionTitle\n  agencyId\n  businessHours\n  microReview\n  tags\n  priceCategory\n  broadcastInfo {\n    program\n    date\n    menu\n    __typename\n  }\n  michelinGuide {\n    year\n    star\n    comment\n    url\n    hasGrade\n    isBib\n    alternateText\n    __typename\n  }\n  broadcasts {\n    program\n    menu\n    episode\n    broadcast_date\n    __typename\n  }\n  tvcastId\n  naverBookingCategory\n  saveCount\n  uniqueBroadcasts\n  isDelivery\n  isCvsDelivery\n  markerLabel @include(if: $isNmap) {\n    text\n    style\n    __typename\n  }\n  imageMarker @include(if: $isNmap) {\n    marker\n    markerSelected\n    __typename\n  }\n  isTableOrder\n  isPreOrder\n  isTakeOut\n  bookingDisplayName\n  bookingVisitId\n  bookingPickupId\n  popularMenuImages {\n    name\n    price\n    bookingCount\n    menuUrl\n    menuListUrl\n    imageUrl\n    isPopular\n    usePanoramaImage\n    __typename\n  }\n  visitorReviewCount\n  visitorReviewScore\n  detailCid {\n    c0\n    c1\n    c2\n    c3\n    __typename\n  }\n  streetPanorama {\n    id\n    pan\n    tilt\n    lat\n    lon\n    __typename\n  }\n  __typename\n}\n\nfragment NluFields on Nlu {\n  queryType\n  user {\n    gender\n    __typename\n  }\n  queryResult {\n    ptn0\n    ptn1\n    region\n    spot\n    tradeName\n    service\n    selectedRegion {\n      name\n      index\n      x\n      y\n      __typename\n    }\n    selectedRegionIndex\n    otherRegions {\n      name\n      index\n      __typename\n    }\n    property\n    keyword\n    queryType\n    nluQuery\n    businessType\n    cid\n    branch\n    franchise\n    titleKeyword\n    location {\n      x\n      y\n      default\n      longitude\n      latitude\n      dong\n      si\n      __typename\n    }\n    noRegionQuery\n    priority\n    showLocationBarFlag\n    themeId\n    filterBooking\n    repRegion\n    repSpot\n    dbQuery {\n      isDefault\n      name\n      type\n      getType\n      useFilter\n      hasComponents\n      __typename\n    }\n    type\n    category\n    menu\n    context\n    __typename\n  }\n  __typename\n}\n',
    'variables' => array(
      'input' => array(
        'bounds'     => '126.94427490234376;37.47104343647654;127.16297149658203;37.56213302799114',
        'deviceType' => 'pcmap',
        'display'    => 50,
        'isNmap'     => false,
        'query'      => '강남 중식당',
        'start'      => 1,
      ),
      'isBounds' => true,
      'isNmap' => false
    )
  ),

  'getPlacesList' => array(
    'operationName' => 'getPlacesList',
    'query' => 'query getPlacesList($input: PlacesInput, $isNmap: Boolean!, $isBounds: Boolean!) {\n  places: places(input: $input) {\n    total\n    items {\n      id\n      name\n      normalizedName\n      category\n      detailCid {\n        c0\n        c1\n        c2\n        c3\n        __typename\n      }\n      categoryCodeList\n      dbType\n      distance\n      roadAddress\n      address\n      commonAddress\n      bookingUrl\n      phone\n      virtualPhone\n      businessHours\n      daysOff\n      imageUrl\n      imageCount\n      x\n      y\n      poiInfo {\n        polyline {\n          shapeKey {\n            id\n            name\n            version\n            __typename\n          }\n          boundary {\n            minX\n            minY\n            maxX\n            maxY\n            __typename\n          }\n          details {\n            totalDistance\n            arrivalAddress\n            departureAddress\n            __typename\n          }\n          __typename\n        }\n        polygon {\n          shapeKey {\n            id\n            name\n            version\n            __typename\n          }\n          boundary {\n            minX\n            minY\n            maxX\n            maxY\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      subwayId\n      markerLabel @include(if: $isNmap) {\n        text\n        style\n        stylePreset\n        __typename\n      }\n      imageMarker @include(if: $isNmap) {\n        marker\n        markerSelected\n        __typename\n      }\n      oilPrice @include(if: $isNmap) {\n        gasoline\n        diesel\n        lpg\n        __typename\n      }\n      isPublicGas\n      isDelivery\n      isTableOrder\n      isPreOrder\n      isTakeOut\n      isCvsDelivery\n      hasBooking\n      naverBookingCategory\n      bookingDisplayName\n      bookingBusinessId\n      bookingVisitId\n      bookingPickupId\n      easyOrder {\n        easyOrderId\n        easyOrderCid\n        businessHours {\n          weekday {\n            start\n            end\n            __typename\n          }\n          weekend {\n            start\n            end\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      baemin {\n        businessHours {\n          deliveryTime {\n            start\n            end\n            __typename\n          }\n          closeDate {\n            start\n            end\n            __typename\n          }\n          temporaryCloseDate {\n            start\n            end\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      yogiyo {\n        businessHours {\n          actualDeliveryTime {\n            start\n            end\n            __typename\n          }\n          bizHours {\n            start\n            end\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      isPollingStation\n      hasNPay\n      talktalkUrl\n      visitorReviewCount\n      visitorReviewScore\n      blogCafeReviewCount\n      bookingReviewCount\n      streetPanorama {\n        id\n        pan\n        tilt\n        lat\n        lon\n        __typename\n      }\n      naverBookingHubId\n      bookingHubUrl\n      bookingHubButtonName\n      __typename\n    }\n    optionsForMap @include(if: $isBounds) {\n      maxZoom\n      minZoom\n      includeMyLocation\n      maxIncludePoiCount\n      center\n      displayCorrectAnswer\n      correctAnswerPlaceId\n      spotId\n      __typename\n    }\n    __typename\n  }\n}\n',
    'variables' => array(
      'input' => array(
        'adult'      => false,
        'bounds'     => '126.94427490234376;37.47104343647654;127.16297149658203;37.56213302799114',
        'deviceType' => 'pcmap',
        'display'    => 50,
        'query'      => '강동구미용실',
        'queryRank'  => '',
        'spq'        => false,
        'start'      => 1,
      ),
      'isBounds' => true,
      'isNmap' => false
    )
  ),

  'getBeautyListnail' => array(
    'operationName' => 'getBeautyList',
    'query' => 'query getBeautyList($input: BeautyListInput, $businessType: String, $isNmap: Boolean!, $isBounds: Boolean!) {\n  businesses: nailshops(input: $input) {\n    total\n    items {\n      ...BeautyItemFields\n      imageMarker @include(if: $isNmap) {\n        marker\n        markerSelected\n        __typename\n      }\n      markerLabel @include(if: $isNmap) {\n        text\n        style\n        __typename\n      }\n      __typename\n    }\n    nlu {\n      ...NluFields\n      __typename\n    }\n    optionsForMap @include(if: $isBounds) {\n      maxZoom\n      minZoom\n      includeMyLocation\n      maxIncludePoiCount\n      center\n      __typename\n    }\n    userGender\n    __typename\n  }\n  brands: beautyBrands(input: $input, businessType: $businessType) {\n    name\n    cid\n    __typename\n  }\n}\n\nfragment NluFields on Nlu {\n  queryType\n  user {\n    gender\n    __typename\n  }\n  queryResult {\n    ptn0\n    ptn1\n    region\n    spot\n    tradeName\n    service\n    selectedRegion {\n      name\n      index\n      x\n      y\n      __typename\n    }\n    selectedRegionIndex\n    otherRegions {\n      name\n      index\n      __typename\n    }\n    property\n    keyword\n    queryType\n    nluQuery\n    businessType\n    cid\n    branch\n    franchise\n    titleKeyword\n    location {\n      x\n      y\n      default\n      longitude\n      latitude\n      dong\n      si\n      __typename\n    }\n    noRegionQuery\n    priority\n    showLocationBarFlag\n    themeId\n    filterBooking\n    repRegion\n    repSpot\n    dbQuery {\n      isDefault\n      name\n      type\n      getType\n      useFilter\n      hasComponents\n      __typename\n    }\n    type\n    category\n    menu\n    context\n    __typename\n  }\n  __typename\n}\n\nfragment BeautyItemFields on BeautySummary {\n  id\n  name\n  hasBooking\n  hasNPay\n  hasPostNPay\n  blogCafeReviewCount\n  bookingReviewCount\n  bookingReviewScore\n  description\n  roadAddress\n  address\n  imageUrl\n  talktalkUrl\n  distance\n  x\n  y\n  representativePrice {\n    isFiltered\n    priceName\n    price\n    __typename\n  }\n  nPayPromotions {\n    payPercentage\n    postPaidPercentage\n    __typename\n  }\n  promotionTitle\n  stylesCount\n  styles {\n    desc\n    styleNum\n    isPopular\n    images {\n      imageUrl\n      __typename\n    }\n    styleOptions {\n      num\n      __typename\n    }\n    __typename\n  }\n  visitorReviewCount\n  visitorReviewScore\n  streetPanorama {\n    id\n    pan\n    tilt\n    lat\n    lon\n    __typename\n  }\n  styleBookingCounts {\n    styleNum\n    name\n    count\n    isPopular\n    __typename\n  }\n  __typename\n}\n',
    'variables' => array(
      'businessType' => 'nailshop',
      'input' => array(
        'adult'      => false,
        'bounds'     => '126.94427490234376;37.47104343647654;127.16297149658203;37.56213302799114',
        'deviceType' => 'pcmap',
        'display'    => 50,
        'query'      => '강동구네일샵',
        'queryRank'  => '',
        'spq'        => false,
        'start'      => 1,
      ),
      'isBounds' => true,
      'isNmap' => false
    )
  ),

  'getAccommodationList' => array(
    'operationName' => 'getAccommodationList',
    'query' => 'query getAccommodationList($input: AccommodationListInput, $isNmap: Boolean!, $isBounds: Boolean!) {\n  businesses: accommodations(input: $input) {\n    total\n    items {\n      id\n      name\n      businessCategory\n      categoryCode\n      category\n      description\n      hasBooking\n      hasNPay\n      x\n      y\n      distance\n      imageUrls\n      imageUrl\n      imageCount\n      phone\n      virtualPhone\n      routeUrl\n      streetPanorama {\n        id\n        pan\n        tilt\n        lat\n        lon\n        __typename\n      }\n      roadAddress\n      address\n      commonAddress\n      blogCafeReviewCount\n      bookingReviewCount\n      bookingReviewScore\n      totalReviewCount\n      bookingUrl\n      bookingBusinessId\n      talktalkUrl\n      options\n      promotionTitle\n      agencyId\n      matchRoomMinPrice\n      avgPrice\n      interiorPanorama\n      matchSidRoomIds\n      bookingUserCount\n      facility\n      placeReviewCount\n      placeReviewScore\n      imageMarker @include(if: $isNmap) {\n        marker\n        markerSelected\n        __typename\n      }\n      markerLabel @include(if: $isNmap) {\n        text\n        style\n        __typename\n      }\n      streetPanorama {\n        id\n        pan\n        tilt\n        lat\n        lon\n        __typename\n      }\n      __typename\n    }\n    filters {\n      region\n      __typename\n    }\n    nlu {\n      queryType\n      queryResult {\n        ptn0\n        ptn1\n        region\n        spot\n        tradeName\n        service\n        selectedRegion {\n          name\n          index\n          x\n          y\n          __typename\n        }\n        selectedRegionIndex\n        otherRegions {\n          name\n          index\n          __typename\n        }\n        property\n        keyword\n        queryType\n        location {\n          x\n          y\n          default\n          longitude\n          latitude\n          dong\n          si\n          __typename\n        }\n        noRegionQuery\n        priority\n        showLocationBarFlag\n        themeId\n        filterBooking\n        dbQuery {\n          isDefault\n          name\n          type\n          getType\n          useFilter\n          hasComponents\n          __typename\n        }\n        type\n        __typename\n      }\n      __typename\n    }\n    optionsForMap @include(if: $isBounds) {\n      maxZoom\n      minZoom\n      includeMyLocation\n      maxIncludePoiCount\n      center\n      spotId\n      __typename\n    }\n    __typename\n  }\n}\n',
    'variables' => array(
      'input' => array(
        'adult'      => false,
        'bounds'     => '126.94427490234376;37.47104343647654;127.16297149658203;37.56213302799114',
        'deviceType' => 'pcmap',
        'display'    => 50,
        'query'      => '강동구미용실',
        'queryRank'  => '',
        'spq'        => false,
        'start'      => 1,
      ),
      'isBounds' => true,
      'isNmap' => false
    )
  ),
);

// php 에서 // 표시는 주석으로 간주하여 실행되지 않습니다.
// 요청할 검색 형식을 설정합니다.
// 검색형식을 등록 후 잘 작동하는지 체크하는 용도로 사용하면 됩니다.
// $op = $operations['getBeautyList'];
// $op = $operations['getRestaurants'];
// $op = $operations['getPlacesList'];

// 검색 결과값을 json 형식으로 받아옵니다.
// $result = fetch($op);

// 필요한 검색 항목을 설정하고 검색합니다.
// 되도록 위의 $operations 항목은 직접 수정하지 마시고 아래처럼 하시기를 권장합니다.
// $myOp = $operations['getPlacesList'];
// $myOp['variables']['input']['adult']  = true;
// $myOp['variables']['input']['bounds'] = '126.94427490234376;37.47104343647654;127.16297149658203;37.56213302799114';
// $myOp['variables']['input']['query']  = '삼성 서비스 센터';
// $myOp['variables']['input']['start']  = 1;
// $myOp['variables']['input']['x']      = '127.01396942138707';
// $myOp['variables']['input']['y']      = '37.51728291676506';
// $result = fetch($myOp);

function get_time() { $t=explode(' ',microtime()); return (float)$t[0]+(float)$t[1]; }
if(strpos($keyword, '미용실') !== false) {
  $myOp2 = $operations['getBeautyList'];
} elseif(strpos($keyword, '네일') !== false) {
  $myOp2 = $operations['getBeautyListnail'];
} elseif(strpos($keyword, '펜션') !== false){
  $myOp2 = $operations['getAccommodationList'];
} elseif(strpos($keyword, '맛집') !== false){
  $myOp2 = $operations['getRestaurants'];
} else{
  $myOp2 = $operations['getPlacesList'];
}


// $myOp2['variables']['input']['bounds'] = '126.99594497680665;37.49420080481394;127.1052932739258;37.53974537352321';
$myOp2['variables']['input']['query']  = $keyword;
// $myOp2['variables']['input']['start']  = 1;
// $myOp2['variables']['input']['x']      = '127.03079223632814';
// $myOp2['variables']['input']['y']      = '37.51731695590714';
$result = fetch($myOp2,$code);
$array = [];
array_push($array,$result);
echo json_encode($array, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

// print_r($result);
// 결과값을 php 배열 형식으로 보기. json 형식보다는 눈으로 확인하시기에 편합니다.
// echo('<pre>'.print_r(json_decode($result, true), true).'</pre>');

// 결과값을 json 형식으로 출력
// echo($result);

// 페이지 실행 종료
exit;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// 요청한 값으로 네이버 지도에 질의하고 결과값을 받아오는 함수입니다.
// 이 부분은 수정하실 필요없습니다.
function fetch ($_operation,$codes) {
  // $start = get_time();
  $my_code = $codes;
  $operation = array(
    $_operation
  );
  $operation[0]['query'] = str_replace('\n', '', $operation[0]['query']);
  $page_num = 1;
  $count_num = 1;
  $page_check = True;
  while(True){
    if ($page_check == False){
      break;
    }
    $operation[0]['variables']['input']['start'] = $page_num;
    $keyword = ($operation[0]['variables']['input']['query']);
    $url = 'https://pcmap-api.place.naver.com/place/graphql';
    $header = array(
      'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36',
      'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
      'Accept-Language: ko-KR,ko;q=0.8,en-US;q=0.5,en;q=0.3',
      'Accept-Encoding: gzip, deflate',
      'Content-Type: application/json',
      'Origin: https://pcmap.place.naver.com'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($operation));
    curl_setopt($ch, CURLOPT_ENCODING , 'gzip');

    // 네이버맵에서 질의하고 결과값 받아오기
    $resp = curl_exec($ch);
    $info = curl_getinfo($ch);
    $errno = curl_errno($ch);
    $errMsg = curl_error($ch);
    curl_close($ch);

    // 오류처리
    if ($info['http_code'] != 200) {
      $errors = array(
        'resp'         => $resp,
        'info'         => $info,
        'respCode'     => $info['http_code'],
        'curlErrorNo'  => $errno,
        'curlErrorMsg' => $errMsg
      );
      $resp = json_encode($errors);
    }
    $resps = json_decode($resp);

    if(strpos($keyword, '미용실') !== false) {
      $results = ($resps[0]->data->businesses->items);
    } elseif(strpos($keyword, '네일') !== false) {
      $results = ($resps[0]->data->businesses->items);
    } elseif(strpos($keyword, '펜션') !== false){
      $results = ($resps[0]->data->businesses->items);
    } elseif(strpos($keyword, '맛집') !== false){
      $results = ($resps[0]->data->restaurants->items);
    } else{
      $results = ($resps[0]->data->places->items);
    }
    if(empty($results)){
      $count_num = '등수 미확인';
      break;
    }
    foreach ($results as $key) {
      $codes = $key->id;
      if(strpos((string)$codes, (string)$my_code) !== false) {
          $page_check = False;
          break;
      } else {
          echo "";
      }
      $count_num += 1;
    }
    $page_num += 50;
    sleep(0.5);
  }
  // $end = get_time();
  // $time = $end - $start;
  // echo "<br>";
  // echo number_format($time,6) . " 초 걸림";
  return $count_num;
}
