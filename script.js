function initAutocomplete() {
    function success(position) {
        var latitude  = position.coords.latitude;//緯度
        var longitude = position.coords.longitude;//経度
        latitude = latitude.toFixed(6);
        longitude = longitude.toFixed(6);
        // 位置情報
        var latlng = new google.maps.LatLng( latitude , longitude ) ;
        // Google Mapsに書き出し
        var map = new google.maps.Map( document.getElementById( 'map' ) , {
            zoom: 15 ,// ズーム値
            center: latlng ,// 中心座標
        } ) ;
        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                var icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };

                // Create a marker for each place.
                markers.push(new google.maps.Marker({
                    map: map,
                    icon: icon,
                    title: place.name,
                    position: place.geometry.location
                }));

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });

        var customLabel = {
            restaurant: {
                label: 'R'
            },
            bar: {
                label: 'B'
            }
        };

        var infoWindow = new google.maps.InfoWindow;
        // Change this depending on the name of your PHP or XML file
        //https://tb-210068.tech-base.net/mission7/toxml.php
        //https://tb-210065.tech-base.net/group/toxml.php
        downloadUrl('https://tb-210068.tech-base.net/mission7/toxml.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
                var id = markerElem.getAttribute('id');
                var name = markerElem.getAttribute('name');
                var address = markerElem.getAttribute('address');
                var type = markerElem.getAttribute('type');
                var comment = markerElem.getAttribute('comment');
                var point = new google.maps.LatLng(
                    parseFloat(markerElem.getAttribute('lat')),
                    parseFloat(markerElem.getAttribute('lng')));

                var infowincontent = document.createElement('div');
                var info = document.createElement('strong');
                info.textContent = "・ゴミ箱の情報 / IMFORMATION";
                infowincontent.appendChild(info);
                infowincontent.appendChild(document.createElement('br'));

                var strong = document.createElement('text');

                strong.textContent = name
                infowincontent.appendChild(strong);
                infowincontent.appendChild(document.createElement('br'));
                infowincontent.appendChild(document.createElement('br'));

                var clean = document.createElement('strong');
                clean.textContent = "・清潔感 / Was it clean?";
                infowincontent.appendChild(clean);
                infowincontent.appendChild(document.createElement('br'));

                var text = document.createElement('text');
                text.textContent = address
                infowincontent.appendChild(text);
                infowincontent.appendChild(document.createElement('br'));
                infowincontent.appendChild(document.createElement('br'));

                var titlecom= document.createElement('strong');
                titlecom.textContent = "・コメント / Comment";
                infowincontent.appendChild(titlecom);
                infowincontent.appendChild(document.createElement('br'));
                var textcom = document.createElement('text');
                textcom.textContent = comment;
                infowincontent.appendChild(textcom);
                var icon = customLabel[type] || {};
                var marker = new google.maps.Marker({
                    map: map,
                    position: point,
                    label: icon.label
                });
                marker.addListener('click', function() {
                    infoWindow.setContent(infowincontent);
                    infoWindow.open(map, marker);
                });
            });
        });

        // マーカーの新規出力
        new google.maps.Marker( {
            map: map ,
            position: latlng ,
        } ) ;
    };
    function error() {
        //エラーの場合
        output.innerHTML = "座標位置を取得できません";
    };


    navigator.geolocation.getCurrentPosition(success, error);//成功と失敗を判断
}



function downloadUrl(url, callback) {
    var request = window.ActiveXObject ?
        new ActiveXObject('Microsoft.XMLHTTP') :
    new XMLHttpRequest;

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
        }
    };
    request.open('GET', url, true);
    request.send(null);

}
// getting data from mysql
function doNothing() {}


