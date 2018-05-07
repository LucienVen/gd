<template>
    <div id="home">
        <!-- 首页介绍，开始规划按钮 -->
        <el-row :gutter="20" justify="center" v-if="false">
            <el-col :span="24" style="height:500px;">
                <echart-demo></echart-demo>
                <!-- <bar-chart></bar-chart> -->
                <!-- <carousel-photo></carousel-photo> -->

            </el-col>
        </el-row>
        <!-- 暂时放置echarts demo -->
        <el-row :gutter="20" justify="center" >
            <!-- <h1>hello world!</h1> -->
            <!-- <pie></pie> -->
            <!-- <bar-chart></bar-chart> -->
            <map-echarts></map-echarts>
        </el-row>
        <el-row :gutter="20" justify="center">
            <router-link to="/plan">
                <el-button>开始规划行程</el-button>
            </router-link>
        </el-row>

        <el-row :gutter="20" justify="center">
            <div class="block">
                <p style="line-height:10px; padding-top:20px;">景区热度分布</p>
                <el-carousel trigger="click" height="600px" interval="5000">
                    <el-carousel-item>
                        <carousel-photo-1></carousel-photo-1>
                        <!-- <echart-demo></echart-demo> -->
                    </el-carousel-item>
                    <el-carousel-item>
                        <carousel-photo-2></carousel-photo-2>
                    </el-carousel-item>
                    <el-carousel-item>
                        <carousel-photo-3></carousel-photo-3>
                    </el-carousel-item>
                    <el-carousel-item>
                        <carousel-photo-4></carousel-photo-4>
                    </el-carousel-item>
                </el-carousel>
            </div>
        </el-row>
        <!-- 卡片 -->
        <el-row>
            <!-- <el-col :span="6"></el-col> -->
            <el-col :span="12" :offset="6" justify="center" style="margin-top:30px;">
                <h2 style="line-height:40px;">为你推荐</h2>
                <p style="line-height:5px;">（根据用户注册时选择喜爱的景点类型推荐）</p>
            </el-col>
        </el-row>
        <!-- <h1>为你推荐</h1> -->
        <el-row :gutter="20" id="recommend-card">
            <el-col :span="3">
                <i class="el-icon-d-arrow-left"></i>
            </el-col>
            <el-col :span="6">
                <el-card :body-style="cardStyle" shadow="hover">
                    <img src="../assets/1.png" class="card-img">
                    <div class="card-content">
                        <span>万青</span>
                    </div>
                </el-card>
            </el-col>
            <el-col :span="6">
                <el-card :body-style="cardStyle" shadow="hover">
                    <img src="../assets/2.jpeg" class="card-img">
                    <div class="card-content">
                        <span>万青</span>
                    </div>
                </el-card>
            </el-col>
            <el-col :span="6">
                <el-card :body-style="cardStyle" shadow="hover">
                    <img src="../assets/3.jpg" class="card-img">
                    <div class="card-content">
                        <span>万青</span>
                    </div>
                </el-card>
            </el-col>
            <el-col :span="3">
                <i class="el-icon-d-arrow-right"></i>
            </el-col>
        </el-row>
    </div>
</template>

<script>
// import EchartDemo from './page/EchartDemo';
import EchartDemo from './page/EcDemo'
import CarouselPhoto1 from './carousel/CarouselPhoto1'
import CarouselPhoto2 from './carousel/CarouselPhoto2'
import CarouselPhoto3 from './carousel/CarouselPhoto3'
import CarouselPhoto4 from './carousel/CarouselPhoto4'
import MapEcharts from './echarts/map'
export default {
  data() {
    return {
      currentDate: new Date(),
      cardStyle: {
        padding: 0
      }
    }
  },
  components: {
    'echart-demo': EchartDemo,
    'carousel-photo-1': CarouselPhoto1,
    'carousel-photo-2': CarouselPhoto2,
    'carousel-photo-3': CarouselPhoto3,
    'carousel-photo-4': CarouselPhoto4,
    'map-echarts': MapEcharts
  }
}
</script>

<style scoped>
/* #recommend-card{
    padding-top: 10px;
    margin-top: 10px;
} */
.demo {
  background-color: goldenrod;
}

.card-content {
  padding: 14px;
}
.card-img {
  width: 100%;
  display: block;
}

/* 走马灯样式 */
.el-carousel__item h3 {
  color: #475669;
  font-size: 14px;
  opacity: 0.75;
  line-height: 150px;
  margin: 0;
}

.el-carousel__item:nth-child(2n) {
  background-color: #99a9bf;
}

.el-carousel__item:nth-child(2n + 1) {
  background-color: #d3dce6;
}
</style>
