//----------------------------------------------------------------
// <copyright file="Default.aspx.cs" >
//    Copyright (c) www.Ftodo.com , All rights reserved.
//    author:brightwang E-Mail:brightwang1984@gmail.com 　MyBlog:http://brightwang.cnblogs.com/
//    All rights reserved.
// </copyright>
//----------------------------------------------------------------

using System;
using System.Collections.Generic;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.IO;

public partial class _Default : System.Web.UI.Page 
{
    public int width;
    public int height;
    public string bigHeadImage;
    protected void Page_Load(object sender, EventArgs e)
    {
        if (!IsPostBack)
        {
            ImageHelp imageHelp = new ImageHelp();
            ImageInformation imageInfo = (ImageInformation)imageHelp.GetImageInfo(Server.MapPath("~/image/无标题.jpg"));
            width = imageInfo.Width;
            height = imageInfo.Height;
            string path = "~/User/UserHeadImage" + "/normal.jpg";
            string defaultPath = "~/image/man.GIF";
            if (File.Exists(Server.MapPath(path)))
                img_CurrentHeadImage.ImageUrl = path;
            else
                img_CurrentHeadImage.ImageUrl =defaultPath;
        }
    }
    protected void btn_Image_Click(object sender, EventArgs e)
    {
        int imageWidth = Int32.Parse(txt_width.Text.Replace("px", ""));
        int imageHeight = Int32.Parse(txt_height.Text.Replace("px", ""));
        int cutTop = Int32.Parse(txt_top.Text);
        int cutLeft = Int32.Parse(txt_left.Text);
        int dropWidth = Int32.Parse(txt_DropWidth.Text);
        int dropHeight = Int32.Parse(txt_DropHeight.Text);
        ImageHelp imgHelp = new ImageHelp();
        string savepath = "User/UserHeadImage" + "/";
        imgHelp.GetPart(Server.MapPath("~/image/无标题.jpg"), Server.MapPath(savepath), 0, 0, dropWidth, dropHeight, cutLeft, cutTop, imageWidth, imageHeight);
        string NormalHeadImageUrl = savepath + "normal.jpg";
        Response.Redirect(Request.RawUrl);
    }
}
