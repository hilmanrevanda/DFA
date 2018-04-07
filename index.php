<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DFA</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <script type="text/javascript" src="js/go.js"></script>
    <script type="text/javascript">
      function goIntro() {
        var diagram = new go.Diagram("myDiagramDiv");

        diagram.model = new go.Model.fromJson(document.getElementById("mySavedModel").value);
      }
    </script>
  </head>

  <body>
    <div class="container">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Teuku Hilman Revanda (001201500038)</h1>
          <p class="lead">
            References:<br>
            https://codepen.io/anon/pen/aqGQqO (Text to speech)<br>
            http://gojs.net/ (diagram)<br>
          </p>
        </div>
      </div>
      <div class="list-group">
        <div class="list-group-item list-group-item-action flex-column align-items-start">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">Step 1</h5>
          </div>
          <p class="mb-1">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">How many states ?</span>
              </div>
              <input type="text" class="form-control state-size" aria-label="Default" aria-describedby="inputGroup-sizing-default">
            </div>

            <button type="button" class="btn btn-primary state-button">Generate</button>
          </p>
        </div>
        <div class="list-group-item list-group-item-action flex-column align-items-start">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">Step 2</h5>
          </div>
          <p class="mb-1">

            <table class="table">
              <thead>
                <tr>
                  <th scope="col">State</th>
                  <th scope="col">0</th>
                  <th scope="col">1</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>

          </p>
        </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">Step 3</h5>
          </div>
          <p class="mb-1">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Start</span>
              </div>
              <input type="text" class="start-state form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">End</span>
              </div>
              <input type="text" class="end-state form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
            </div>

          </p>
          <small class="text-muted">
            ex: 1,2,3,4,...
          </small>
        </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">Step 4</h5>
          </div>
          <p class="mb-1">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Strings</span>
              </div>
              <input type="text" class="strings form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
            </div>
            <button type="button" class="submit btn btn-primary">Submit</button>
          </p>
        </div>
      </div>

      <!-- result -->
      <!-- Modal -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Result</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="myDiagramDiv" style="border: solid 1px blue; width: 400px; height: 300px;"></div>
              <p class="msg"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript">
    var states = 0;

    $(".state-button").on("click", function () {
      var size = $(".state-size").val();
      states = size;

      $("table.table tbody").text("");

      for (var i = 1 ; i <= size; i++) {
        $("table.table tbody").append("<tr>"  
                                        +"<th scope='row'>" + i + "</th>"
                                        +"<td><input class='state" + i +"in0' type='number' name='state" + i +"in0' min='1' max='" + size + "'></td>"
                                        +"<td><input class='state" + i +"in1' type='number' name='state" + i +"in1' min='1' max='" + size + "'></td></td>"
                                        +"</tr>"
                                        );
      }
    }
    );

    $(".submit").on("click", function() {
      var rules = "";
      var string = $(".strings").val();
      var startstate = $(".start-state").val() - 1;
      var endstate = $(".end-state").val() - 1;

      for (var j = 1; j <= states; j++) {
        rules = rules + ($(".state"+j+"in0").val() - 1) + "," + ($(".state"+j+"in1").val() - 1);
        if(j != states){
          rules = rules + "|";
        }
      }

    $.ajax({
        url: 'run.php',
        type: 'POST',
        data: {
            data: rules,
            input: string,
            start: startstate,
            end: endstate
        },
        success: function(msg) {
            console.log(msg);
            console.log(rules);
            $("#exampleModalCenter").modal("show");

            $(function(){
                  var tts = new SpeechSynthesisUtterance();
                  var voices = window.speechSynthesis.getVoices();
                  tts.voice = voices[0];
                  tts.rate = 1;
                  tts.pitch = 1;
                  tts.text = msg;

                  msg.onend = function(e) {
                    console.log('Finished in ' + event.elapsedTime + ' seconds.');
                  };

                  speechSynthesis.speak(tts);
            });

            $(".msg").text("");

            $(".msg").append(msg);
            var diagram = new go.Diagram("myDiagramDiv");

            var nodeDataArray  = "";

            for (var i = 1; i <= states; i++) {
              nodeDataArray = nodeDataArray + '{ "id": ' + i + ', "loc": "100 100", "text": "Q' + i + '" }';
              if(i != states){
                nodeDataArray = nodeDataArray + ",";
              }
            }

            var linkDataArray  = "";

            for (var i = 1; i <= states; i++) {
              linkDataArray = linkDataArray + '{ "from": ' + i + ', "to": ' + $(".state"+i+"in0").val() + ', "text": "0", "curviness": -20 },';
              linkDataArray = linkDataArray + '{ "from": ' + i + ', "to": ' + $(".state"+i+"in1").val() + ', "text": "1", "curviness": -20 }';
              if(i != states){
                linkDataArray = linkDataArray + ',';
              }
            }

            var jsontxt = '{ "nodeKeyProperty": "id", "nodeDataArray": [' + nodeDataArray + '],"linkDataArray": [' + linkDataArray + ']}';

            diagram.model = new go.Model.fromJson(jsontxt);
            console.log(jsontxt);
        }               
    });

      // console.log(rules);
    });


  </script>
  </body>
</html>
