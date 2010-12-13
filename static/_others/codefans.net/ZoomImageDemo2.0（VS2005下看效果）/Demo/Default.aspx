<%@ Page Language="C#" AutoEventWireup="true" CodeFile="Default.aspx.cs" Inherits="_Default" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>demo</title>
    <link href="css/demo.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery-1[1].2.6.pack.js"></script>

    <script src="js/ui.core.packed.js" type="text/javascript"></script>

    <script src="js/ui.draggable.packed.js" type="text/javascript"></script>

    <script type="text/javascript" src="js/demo.js"></script>
    <!--
    
   ┏━━━━━━━━━━━━━━━━━━━━━┓
   ┃             源 码 爱 好 者               ┃
   ┣━━━━━━━━━━━━━━━━━━━━━┫
   ┃                                          ┃
   ┃           提供源码发布与下载             ┃
   ┃                                          ┃
   ┃        http://www.codefans.net           ┃
   ┃                                          ┃
   ┃            互助、分享、提高              ┃
   ┗━━━━━━━━━━━━━━━━━━━━━┛
    -->

</head>
<body>
    <form id="form1" runat="server">
    <div id="Currentimages" style="overflow: auto;">
        <ul>
            <li>
                <div id="currentImage" runat="server">
                    <h2>当前头像</h2>
                    <hr/>
                    <asp:Image ID="img_CurrentHeadImage" runat="server"/>
                </div>
                <div id="div_HeadImageCut">
                    <h2> 裁切头像照片</h2><hr/>
                    <div id="content">
                        <div id="image">
                            <img id="img" src="image/无标题.jpg" />
                        </div>
                        <div id="drop">
                            <img id="drop_img" src="image/无标题.jpg" />
                        </div>
                    </div>
                    <table>
                        <tr>
                            <td id="Min">
                                    <img alt="缩小" src="image/Minc.gif" style="width: 19px; height: 19px"
                                        id="moresmall" class="smallbig" />
                            </td>
                            <td>
                                <div id="bar">
                                    <div class="child">
                                    </div>
                                </div>
                            </td>
                            <td id="Max">
                                    <img alt="放大" src="image/Maxc.gif" style="width: 19px; height: 19px"
                                        id="morebig" class="smallbig" />
                            </td>
                        </tr>
                    </table>
                    <br />
                    <asp:Button ID="btn_Image" runat="server" Text="保存头像" OnClick="btn_Image_Click" />
                      原尺寸：宽<label id="width" class="Hidden">
                      <%=this.width %></label>px  高：<label id="height" class="Hidden"><%=this.height%>px</label>
                </div>
            </li>
            <li>
            图片实际宽度： <asp:TextBox ID="txt_width" runat="server" Text="1" CssClass="Hidden"></asp:TextBox><br />
            图片实际高度： <asp:TextBox ID="txt_height" runat="server" Text="1" CssClass="Hidden"></asp:TextBox><br />
            距离顶部： <asp:TextBox ID="txt_top" runat="server" Text="1" CssClass="Hidden"></asp:TextBox><br />
            距离左边： <asp:TextBox ID="txt_left" runat="server" Text="1" CssClass="Hidden"></asp:TextBox><br />
            截取框的宽： <asp:TextBox ID="txt_DropWidth" runat="server" Text="1" CssClass="Hidden"></asp:TextBox><br />
            截取框的高： <asp:TextBox ID="txt_DropHeight" runat="server" Text="1" CssClass="Hidden"></asp:TextBox><br />
            放大倍数： <asp:TextBox ID="txt_Zoom" runat="server" Text="1" CssClass="Hidden"></asp:TextBox>
            </li>
        </ul>
    </div>
    </form>
</body>
</html>
