<template>
    <div id="baiduMap">
        
    </div>    
</template>

<script>
export default{
    mounted() {
        var map = new BMap.Map("baiduMap");    // 创建Map实例
	map.centerAndZoom("重庆",12);
    //添加地图类型控件
    var pointA = new BMap.Point(106.486654,29.490295);  // 创建点坐标A--大渡口区
    var pointB = new BMap.Point(106.581515,29.615467);  // 创建点坐标B--江北区
    var pointC = new BMap.Point(106.581515,29.515467);  // 创建点坐标B--江北区
    var marker2 = new BMap.Marker(pointA);
    var marker1 = new BMap.Marker(pointB);
    var marker3 = new BMap.Marker(pointC);
    var opts = {
	  position : pointA,    // 指定文本标注所在的地理位置
	  offset   : new BMap.Size(20, 0)    //设置文本偏移量
	}
    marker2.setLabel(new BMap.Label("1", opts));
    map.addOverlay(marker2);
    map.addOverlay(marker1);
    map.addOverlay(marker3);
    var polyline = new BMap.Polyline([pointA,pointB, pointC], {strokeColor:"red", strokeWeight:3, strokeOpacity:1});  //定义折线
    polyline.setStrokeStyle("dashed");
    map.addOverlay(polyline);     //添加折线到地图上
	map.addControl(new BMap.MapTypeControl({
		mapTypes:[
            BMAP_NORMAL_MAP,
            BMAP_HYBRID_MAP
        ]}));	  
	map.setCurrentCity("重庆");          // 设置地图显示的城市 此项是必须设置的
	map.enableScrollWheelZoom(true);
    }
}    
</script>

<style scoped>
    #baiduMap{
        min-height: 500px;
    }
</style>
