app.controller('techniciansCtrl', function ($scope, technicians, technicians_map) {
    $scope.filteredTechnicians = [];
    $scope.markers = [];
    $scope.tech = technicians.technicians;
    $scope.numPerPage = 6;
    $scope.maxSize = 5;
    $scope.currentPage = 1;

    $scope.$watch('currentPage + numPerPage'/*, update*/);

    technicians_map.cargarmap(technicians.technicians, $scope);

    $scope.select = function (id) {
        for (var i = 0;i < $scope.markers.length; i++) {
            var marker = $scope.markers[i];
            if (id == marker.get('id')){
                if (marker.getAnimation() !== null){
                    marker.setAnimation(null);
                }else{
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                    $scope.map.setCenter(marker.latlon);
                }
                break;
            }
        }
    };
/*
    function update(){
        var begin = (($scope.currentPage - 1) * $scope.numPerPage), end = begin + $scope.numPerPage;
        $scope.filteredTechnicians = $scope.tech.slice(begin, end);
    }*/
});

app.controller('detailsCtrl', function ($scope, data, services, CommonService, cookiesService) {

    $scope.data = data.technicians;
});
