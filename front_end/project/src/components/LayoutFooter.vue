<template>
    <div id="footer">
        <el-row type="flex" class="row-bg" justify="center">
            <el-col :span="6">
                <div class="footer-item-box">
                    <div class="item-box-title">
                        技术选型
                    </div>
                    <p></p>
                    <div class="item-box-content">
                        <p>vue</p>
                        <p>webpack</p>
                        <p>npm</p>
                        <p>ElementUI</p>
                    </div>
                </div>
            </el-col>
            <el-col :span="6">

                <div class="footer-item-box">
                    <div class="item-box-title">
                        数据来源
                    </div>
                    <p></p>
                    <div class="item-box-content">
                        <p>携程网</p>
                        <p>去哪儿网</p>
                        <p>豆瓣</p>
                        
                    </div>
                </div>

            </el-col>
            <el-col :span="6">
                <div class="footer-item-box">
                    <div class="item-box-title">
                        联系我们
                    </div>
                    <p></p>
                    <div class="item-box-content">
                        <p>微博</p>
                        <p>github</p>
                        <p>知乎</p>
                    </div>
                </div>
            </el-col>
            
        </el-row>

    </div>
</template>

<script>
</script>

<style scoped>
#footer {
  width: 100%;
  font-family: 'Microsoft YaHei';
}

/* .bg-purple {
  background: #d3dce6;
} */

.footer-item-box {
  /* margin-top: 20px; */
  padding: 50px;
  text-align: left;
  /* background-color: #fff; */
  color: #fff;
}

.item-box-title {
  font-size: 18px;
  
}

.item-box-content p {
  margin: 0;
  font-size: 12px;
  /* text-align: left; */
}
</style>

