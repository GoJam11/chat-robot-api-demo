<template>
  <div id="app">
    <el-card class="box-card" id="card">
      <div slot="header" class="clearfix">
        <el-button class="bar-button" style="color:#F56C6C" icon="el-icon-circle-close" type="text"></el-button>
        <el-button
          class="bar-button"
          style="color:#E6A23C"
          icon="el-icon-remove"
          type="text"
          @click="minimize"
        ></el-button>
        <el-button
          class="bar-button"
          style="color:#67C23A"
          icon="el-icon-circle-plus"
          type="text"
          @click="fullscreen"
        ></el-button>
        <span style="font-size:18px">与jelly的会话</span>
        <el-popover
          placement="top-start"
          title="帮助"
          width="200"
          trigger="hover"
          content="这是一个聊天系统，你想和AI对话吗？"
        >
          <el-button slot="reference" style="float: right; padding: 3px 0" type="text">查看帮助</el-button>
        </el-popover>
      </div>
      
       
        <el-container direction="vertical" class="main_footer">
          <el-main style="overflow-y :auto;" class="main" ref="main" id="main">
            <p
              v-for="item in textgroups"
              :key="item.id"
              :class="{left:item.robot,right:!item.robot}"
            >
              <el-card
                shadow="hover"
                :class="{robot:item.robot,me:!item.robot}"
                class="card"
              >{{item.content}}</el-card>
            </p>
            <!--<el-card
              shadow="hover"
              v-for="item in textgroups"
              :key="item.id"
              :class="{left:item.robot,right:!item.robot}"
            >
              <span :class="{robot:item.robot,me:!item.robot}">{{item.content}}</span>
            </el-card>-->
          </el-main>
          <el-footer >
            <el-input
              type="textarea"
              resize="none"
              placeholder="请输入内容"
              v-model="textarea3"
              autofocus="true"
              v-on:keydown.enter.native="submit"
            ></el-input>
            <!--:autosize="{ minRows: 2, maxRows: 4}"-->
            <div class="submit">
            <el-button type="primary" size="mini" @click="submit"  >发送</el-button>
          </div>
          </el-footer>
          
        </el-container>
      
    </el-card>
  </div>
</template>

<script>
import HelloWorld from "./components/HelloWorld.vue";

export default {
  name: "app",
  components: {
    HelloWorld
  },
  data: function() {
    return {
      textarea3: "",
      text: "文本在这里",
      textgroups: [{ content: "hello", id: 0, robot: true }]
    };
  },
  methods: {
    submit: function() {
      if (this.textarea3 == "") {
        this.$message({ message: "消息不能为空！", type: "warning" });
        return;
      }
      this.textgroups.push({
        content: this.textarea3,
        robot: false,
        id: this.textgroups.length
      });
      setTimeout(() => {
        window.document.getElementById(
          "main"
        ).scrollTop = window.document.getElementById("main").scrollHeight;
      }, 20);
      this.getResponse();
      this.$message({ message: "发送成功！", type: "success" });
    },
    getResponse: function() {
      this.$jsonp("http://api.guohere.com/tuling123.php", {
        text: this.textarea3,
        apikey: "304f40ddd4054b5cb8e26f4ab222a6d4",
        userid: "c6c11023a55952fb"
      })
        .then(res => {
          console.log(res.results[0].values.text);
          this.textarea3 = "";
          this.textgroups.push({
            content: res.results[0].values.text,
            robot: true,
            id: this.textgroups.length
          });
          setTimeout(() => {
            window.document.getElementById(
              "main"
            ).scrollTop = window.document.getElementById("main").scrollHeight;
          }, 20);
        })
        .catch(err => {
          console.log(err);
        });
    },
    fullscreen: function() {
      var card = window.document.getElementById("card");
      card.style.width = "100%";
      card.style.marginTop = 0;
      card.style.height = window.screen.availHeight;
      var elmain = window.document.getElementById("main");
      elmain.style.maxHeight = window.screen.availHeight + "px";
      elmain.style.height = window.screen.availHeight - 370 + "px";
    },
    minimize: function() {
      var card = window.document.getElementById("card");
      console.log(window.screen.availWidth);
      if (window.screen.availWidth > 750) {
        card.style.width = "720px";
      }
      card.style.marginTop = "60px";
      var elmain = window.document.getElementById("main");
      elmain.style.maxHeight = "400px";
    }
  }
};
</script>

<style>
#app {
  font-family: "Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB",
    "Microsoft YaHei", "微软雅黑", Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  /**margin-top: 90px;
  background: #2c3e50;
  height: 100px;**/
}
.text {
  font-size: 14px;
}

.item {
  margin-bottom: 18px;
}

.clearfix:before,
.clearfix:after {
  display: table;
  content: "";
}
.clearfix:after {
  clear: both;
}

@media screen and (min-device-width: 750px) {
  .box-card {
    width: 720px;
    margin: auto;
    margin-top: 60px;
  }
  .main_footer{
    margin-bottom: 13px
  }
  .main{
    max-height:400px
  }
}

@media screen and (max-device-width: 750px) {
  .box-card {
    width: 100%;
  }
  #app {
    margin-top: 0px;
    height: 100%;
  }
  html {
    height: 100%;
  }

  body {
    height: 100%;
  }

  #card{
    height: 97%;
  }
  .el-card__body{
    height: 80%;
  }
  .main_footer{
    height: 100%;
  }
}

.box-card:hover {
  animation: shake 2s;
  animation-timing-function: linear;
  animation-iteration-count: infinite;
}

@keyframes shake {
  0% {
    transform: rotate(0deg);
  }
  25% {
    transform: rotate(1deg);
  }
  75% {
    transform: rotate(-1deg);
  }
  100% {
    transform: rotate(0deg);
  }
}

@keyframes hoverbar {
}
.bar-button {
  float: left;
  padding: 3px 0 !important;
}

.bar-button:hover {
  transform: scale(2, 2);
}

.submit {
  width: 80px;
  justify-content: flex-end;
  width: 100%;
  margin-top:5px;
  display: flex;
}

.left {
  justify-content: flex-start;
  display: flex;
}
.right {
  justify-content: flex-end;
  display: flex;
}

.robot {
  background: rgb(158, 158, 202) !important;
  padding: 5px 10px;
  border-radius: 3px;
  color: white !important;
}

.left::before {
}

.me {
  background: grey !important;
  padding: 5px 10px;
  border-radius: 3px;
  color: white !important;
  text-align: left;
}

.card > div {
  padding: 5px 10px !important;
}
</style>
