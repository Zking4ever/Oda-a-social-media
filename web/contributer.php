<style>
    .loadingGif{
        display:none;
        justify-content:center;
        flex-direction:column;
        gap:50px;
        color: #9073de;
        text-align:center;
    }
    .loading{
		height:25px;
		width:25px;
		border:solid #9073de;
		border-radius:5px;
		transform-origin:100% 100%;
		animation: load 2.4s ease infinite;
	}
	@keyframes load{
		0%{

			transform:rotateX(0deg) rotateY(0deg);
		}
		25%{
			transform:rotateX(0deg) rotateY(180deg);
		}
		50%{

			transform:rotateX(180deg) rotateY(180deg);
		}
		75%{

			transform:rotateX(180deg) rotateY(0deg);
		}
		100%{
			transform:rotateX(0deg) rotateY(0deg);
		}
	}
  </style>
<div class="contributers" >
                <div class="loadingGif" style="">
                    <div style='width: 50px;height:50px'> 
                        <div class='loading'></div>
                    </div>
                    <div class = "loadingMessage"> LOADING....</div>
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
                    <button id="btn1" class="btn1" title="previous"><</button>
                    <button id="btn2" class="btn2" title= "next">></button>
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
        display:flex;
        align-items:center;
        transition:all .5s ease;
    }
    .img:hover{
        border-radius:10px;
    }
    .img img{
        width:80px;
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
        <div class="user_profile" style="position:relative">
                        <div style="width:30px;height:30px; position:absolute;top:5px;right:5px;z-index:1;cursor:pointer;" id="close">
                             <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                            </svg>
                        </div>
                    <div class="profile_pic">
                        <a target="_blank"><div class="img"><img></div></a>
                        <div class="info"> <span>First Name L.</span>   <span>username </span> <button>send request</button></div>
                    </div>
                    <div class="stroies">
                        <div class="story"></div>
                    </div>
                    Posts
                    <div class="loaded_post prof" style="width:100%">
                            
                    </div>
        </div>
         <div class="view_story" style="display:none;backdrop-filter:blur(10px);">
                    <button id="btn1_" class='btn1' title="previous"><</button>
                    <button id="btn2_" class='btn2' title= "next">></button>
                    <div class="view_story_div"></div>
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
             z-index: 150;
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