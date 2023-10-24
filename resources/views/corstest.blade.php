<!DOCTYPE html>
<html>
<head>

  <title>Test CORS</title>

</head>

<style>
    body{
        background: black;
        color: white;
        font-family: system-ui;
    }

    h3{
        text-align: center;
        margin-top: 25vh;
    }

    h5{
        text-align: center;
    }

    h4{
        text-align: center;
    }

    button{
        display: block;
        margin: auto;
        background: black;
        border: 2px solid white;
        font-weight: bold;
        color: white;
        cursor: pointer;
        margin-top: 24px;
        width: 150px;
    }

    input{
        display: block;
        margin: auto;
    }

    #response{
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
    }

    #response.hidden{
        visibility: hidden;
    }

    #response .item{
        display: flex;
        flex-direction: column;
        min-width: auto;
        margin: auto;
        justify-content: space-between;
    }

    #response .item p{
        margin: 4px 0;
        font-size: 22px;
    }

    #response .item p.val{
        background: white;
        color: black;
        font-weight: bold;
        font-size: 24px;
        margin: 8px 0;
        padding: 4px 8px;
    }

</style>

<body>

    <h3>Test CORS settings of the application:</h3>

    <h5>Server URL that you want get the content from:</h5>
    <input type="text" id="url" />
    <button onclick="testCORS()"><p>GET<p></button>

    <h4>Status:</h4>

    <div id="response" class="hidden">
        <div class="item"><p>Status:<p> <strong><p class="val" id="responseStatus"><p></strong></div>
        <div class="item"><p>Message:<p> <strong><p class="val" id="responseMessage"><p></strong></div>
    </div>

    <script  type="text/javascript">

        function testCORS(){

            if(!document.getElementById('url').value) return;

            document.getElementById('response').classList.add('hidden');

            const xhttp = new XMLHttpRequest();
            xhttp.open("GET", document.getElementById('url').value, true);

            xhttp.responseType = "json";

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if(this.status === 0){
                        document.getElementById('responseStatus').innerHTML = 'ERROR';
                        document.getElementById('responseMessage').innerHTML = ' Request failed. Check console for more informations.';
                    } else {
                        document.getElementById('responseStatus').innerHTML = this.status;
                        document.getElementById('responseMessage').innerHTML =  this.statusText;
                    }
                    
                    document.getElementById('response').classList.remove('hidden');
                }
            };

            xhttp.send(null);
        }

    </script>
</body>
</html>