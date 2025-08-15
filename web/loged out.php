<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
        <div class="card">
            You have Loged out.
            <span onclick="goToIndex()" style="font-size:50px;">😥</span>
        <div> click<span onclick="goToIndex()"> here </span>to log in </div>
        </div>

</body>
<script>
    function goToIndex(){
          	window.location.assign("https://oda.social-networking.me");
    }
</script>
<style>
    body{
        height:100vh;
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        gap:14px;
        font-size:24px;
        background-color:black;
    }
    .card{
        width: 250px;
        height:250px;
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        gap:10px;
        background-color:black;
        color:#9073de;
        position:relative;
        border-radius:10px
    }
    .card:after,.card::before{
        content:"";
        width: 250px;
        height:250px;
        position:absolute;
        padding:5px;
        border-radius:10px;
        background: conic-gradient(from calc(var(--x)*1deg),transparent 70%,#9073de,#9073de,lightblue);
        z-index: -5;
        animation:move 4s ease infinite;
    }
    .card::before{
        filter:blur(10rem);
        opacity: 0.7;
        backdrop-filter:blur(10px);
        background:unset;
        background-color:lightblue;
        z-index: -1;
    }
    :root{
        --x:90;
    }
    @property --x{
        syntax: "<number>";
        initial-value:90;
        inherits:false;
    }
    @keyframes move {
        from{
            --x:90;
        }
        to{
            --x:450;
        }
    }
    span{
        color:blue;
        cursor:pointer;
    }
    img{
        width:50px;
    }

</style>
</html>