<div class="contributers" >
                <div class="loadingGif" style="display:none;align-items:center;justify-content:center;">
                        LOADING....
                </div>
                <div class="new_post_inputes">
                        <form>
                            <h4>post image</h4>
                            <input type="file" name="file" id="file">
                            <h4>caption</h4>
                            <textarea name="caption" id="caption"></textarea>
                            <input type="button" id="submit" value="post">
                        </form>
                </div>
                <div class="manage_story" style="display:none">
                    <div class="preview">
                        <img id="preview_img" src="">
                        <input id="story_caption" type="text" placeholder="Add a caption..">
                        <button id='share_story'>Share</button>
                    </div>
                </div>
                <div class="view_story" style="display:none">
                    <button id="btn1" title="previous"><</button>
                    <button id="btn2" title= "next">></button>
                    <div class="view_story_div"></div>
                </div>
                


            <div id="myradios" style="display:none">
                <input type="radio" id="home_radio" name="catagory_radios">
                <input type="radio" id="friends_radio" name="catagory_radios">
                <input type="radio" id="thoughts_radio" name="catagory_radios">
                <input type="radio" id="ask_radio" name="catagory_radios">
                <input type="radio" id="councelor_radio" name="catagory_radios">
                <input type="radio" id="settings_radio" name="catagory_radios">
            </div>

</div> 
<style>
    .commentContainer{
            width:68%;
            height:200px;
            background-color:rgb(34,45,65,0.4);
            backdrop-filter:blur(3px);
            border-radius:6px;
            left:50%;
            transform:translateX(-50%);
            position:absolute;
            bottom:60px;
            padding:2px;
            overflow-Y:scroll;
            display:none;
        }
        .loader{
            width:fit-content;
            transform:translateY(96px);
            font-size:35px;
            margin:auto;
        }
        .cloth{
            position:absolute;
            right:2px;
            top:2px;
            cursor:pointer;
        }
        .comment{
                width:95%;
                margin: 3px auto;
                padding:4px;
                border:solid thin;
                border-radius:7px;
                min-height:30px;
                display:flex;
                flex-direction:column;
            }   
            .comment div{
                width:100%;
                display:flex;
                justify-content:space-between;
                align-items:center;
            }
            .comment span{
                margin:0;
                padding:2px;
                width:86%;
                background-color:rgb(224,229,231,0.75);
                overflow-wrap:break-word;
                border-radius:6px;
            }
        @media (max-width:760px) {
            .commentContainer{
                width:98%;
            }
        }
    </style>
<div class='commentContainer'><div class='loader'>Loading..</div> </div>

<style>
    .user_profile{
        width:max(320px,45%);
        height:93%;
        margin:auto;
        background-color:azure;
        border:solid thin #9073de;
        border-radius:10px;
        overflow:hidden;
    }
    .profile_pic{
        height:100px;
        padding-top:2%;
        padding-bottom:.3%;
        padding-left:10%;
        display:flex;
        align-items:center;
        gap:16px;
        background-color:#b19de5;
        position: relative;
    }
    .profile_pic .img{
        width:80px;
        aspect-ratio:1;
        border-radius:50%;
        border:solid;
        overflow:hidden;
    }
    .img img{
        width:80px;
        aspect-ratio:1;
    }
    .profile_pic .info{
        display:flex;
        flex-direction:column;
    }
    .info span:nth-child(2){
        font-size:10px;
        margin-left:5px;
        color:#e7e7e7;
    }
    .info button{
        margin:auto;
        position: absolute;
        bottom:15px;
        font-size:8px;
        cursor:pointer;
    }
    .user_profile .loaded_post{
        height:65%;
    }
    .stroies{
            height:50px;
    }
    .story{
        width: 50px;
        height:50px;
    }
    .prof
    .post{
        width:90%;
        border:2px solid rgb(207 207 207);
    }
    @media (max-width:760px) {
        .user_profile{
            width: max(320px,85%);;
        }
        .profile_pic{
            height:100px;
            padding-top:6%;
            padding-bottom:2%;
        }
        .stroies{
            height:40px;
        }
        .story{
            width: 40px;
            height:40px;
        }
    }
    </style>
<div class="contributers">
        <div class="user_profile" style="">
                    <div class="profile_pic">
                        <div class="img"><img src="backend\Profiles\GEL_1234.JPG"></div>
                        <div class="info"> <span>First Name L.</span>   <span>username </span> <button>send request</button></div>
                    </div>
                    <div class="stroies">
                        <div class="story"></div>
                    </div>
                    Posts
                    <div class="loaded_post prof" style="width:100%">
                            
                    </div>
        </div>
</div>