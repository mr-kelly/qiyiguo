//----------------------------------------------------------------
// <copyright file="demo.js" >
//    Copyright (c) www.Ftodo.com , All rights reserved.
//    author:brightwang E-Mail:brightwang1984@gmail.com 　MyBlog:http://brightwang.cnblogs.com/
//    All rights reserved.
// </copyright>
//----------------------------------------------------------------


        //获取图片大小的方法，在ie下偶尔有问题
        var getSizeImg = function(src)
        {
            var timg = $('<img>').attr('src', src).css({ position: 'absolute', top: '-1000px', left: '-1000px' }).appendTo('body');
            var size = [timg.get(0).offsetWidth, timg.get(0).offsetHeight];

            try { document.body.removeChild(timg[0]); }
            catch (e) { };

            return size;
        };
        //缩放代码
        function bigSmall()
        {
          var size=$(this).attr("id")=="morebig"?0.01:-0.01;
          var value=parseFloat($("#txt_Zoom").val());
          var temp=value+size;
          if(temp<=2)
          {
          $("#txt_Zoom").val((value+size).toString());
          var width=parseInt($("#width").text());
          var height=parseInt($("#height").text());
         $("#img").css({ width:parseInt(width*temp)+ "px", height:parseInt(height*temp) + "px" });
         $("#image").css({ width:parseInt((width*temp))+ "px", height:parseInt((height*temp)) + "px" });
         $("#drop_img").css({ width:parseInt((width*temp))+ "px", height:parseInt((height*temp)) + "px" });
         $("#txt_width").val($("#img").css("width").replace(/px/,""));
         $("#txt_height").val($("#img").css("height").replace(/px/,""));
         $(".child").css({left:parseInt($(".child").eq(0).css("left").replace(/px/,""))+size*100+"px"});
         }
        }
        //初始化
        $(document).ready(
          function()
        {
            var width = parseInt($("#width").text())//图片的原长宽
            var height = parseInt($("#height").text());
            //将图片长宽输入textbox中
            $("#txt_DropWidth").val($("#drop").css("width").replace("px",""));
            $("#txt_DropHeight").val($("#drop").css("height").replace("px", ""));
            
              $("#drop_img").css({left:"-101px",top:"-101px"});//将截取框内的图片移动到适合位置，注意截取框的1px边框
              //设置div的拖动功能
              $("#image").draggable({ cursor: 'move',
                  drag: function(e, ui)
                  {
                      var self = $(this).data("draggable");
                      var drop_img = $("#drop_img");
                      var top = $("#drop_img").css("top").replace(/px/,"");//取出截取框到顶部的距离
                      var left = $("#drop_img").css("left").replace(/px/,"");//取出截取框到左边的距离
                      drop_img.css({left:(parseInt(self.position.left)-101)+"px",top:(parseInt(self.position.top)-101)+"px"});//同时移动内部的图片
                      //drop_img.style.backgroundPosition = (self.position.left - parseInt(left)-1) + 'px ' + (self.position.top - parseInt(top)-1) + 'px';
                      $("#txt_left").val(99-parseInt($(this).css("left")));
                      $("#txt_top").val(99-parseInt($(this).css("top")));
                  }

              });
              
              $("#drop_img").draggable(
                            { cursor: 'move',
                                drag: function(e, ui)
                                {
                                    var self = $(this).data("draggable");
                                    var divimage=$("#image");
                                    //divimage.style.backgroundPosition = parseInt((self.position.left))*300 + 'px ' + parseInt((self.position.top))*300 + 'px';
                                    divimage.css({left:(parseInt(self.position.left)+101)+"px" ,top:(parseInt(self.position.top)+101)+"px"});//同时移动div
                                    
                                     $("#txt_left").val(99-parseInt($("#image").css("left")));
                                     $("#txt_top").val(99-parseInt($("#image").css("top")));
                                }
                            });
              $("#image").css({ opacity: 0.3,backgroundColor:"#fff",width: width + "px", height: height + "px" });
              $("#txt_top").val("100");
              $("#txt_left").val("100");
              $("#txt_width").val(width);
              $("#txt_height").val(height);
              $(".smallbig").click(bigSmall);
              //缩放的代码
              $(".child").draggable(
              {
                cursor:"move",containment:$("#bar"),
                drag:function(e,ui)
                     {
                       var left=parseInt($(this).css("left"));
                       var value=1+(left-100)/100;
                       $("#txt_Zoom").val(value);
                       $("#img,image").css({ width:parseInt(width*value)+ "px", height:parseInt(height*value) + "px" });
                       $("#image").css({ width:parseInt(width*value)+ "px", height:parseInt(height*value) + "px"});
                       $("#drop_img").css({ width:parseInt(width*value)+ "px", height:parseInt(height*value) + "px"});
                       $("#txt_width").val($("#img").css("width").replace(/px/,""));
                       $("#txt_height").val($("#img").css("height").replace(/px/,""));
                     }                      
              });
              
          }
        );