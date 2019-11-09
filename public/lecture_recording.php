<?php include("includes/config.php"); ?>
<!doctype html>
<html lang="en">

  <head>
    <?php include("includes/head.php"); ?>
    <link href="css/lecture_rec.css" rel="stylesheet">

    <script src="http://code.jquery.com/jquery-1.11.0.js"></script>
    <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
  </head>

  <body>
    <?php include("includes/header.php"); ?>
    <main role="main" class="container">

    <h1 class="h3 mb-3 font-weight-normal">Lesson recording</h1>

     <!-- Class selection -->
     <!-- Just a placeholder -->
     <div class="form-group-class">
        <label for="classSelection">Select a class</label>
        <select class="form-control" id="classSelection">
          <option>1A</option>
          <option>2A</option>
          <option>3B</option>
        </select>
      </div>

    <!-- Subject selection -->
    <!-- Just a placeholder -->
    <div class="form-group-class">
      <label for="subjectSelection">Select a subject</label>
      <select class="form-control" id="subjectSelection">
        <option>Science</option>
        <option>Algebra</option>>
      </select>
    </div>

      <!-- Date picker -->
      <div class="form-group-date">
        <label for="dateSelection">Select a date</label><br>
        <input class="datepicker" id="dateSelection" data-date-format="mm/dd/yyyy">
      </div>          
          
      <!-- Setup datepicker -->
      <script>
        $('.datepicker').datepicker({ 
          startDate: '-3d'
        });
      </script>
      </div>
        
      <!-- Hour selection -->
      <div class="form-group-hour">
        <label for="hourSelection">Select an hour</label>
        <select class="form-control" id="hourSelection">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
          <option>6</option>
        </select>
      </div>

      <!-- Text area for lecture's topic recording -->
      <div class="form-group-text">
        <label for="lectureTextArea">Insert the lecture topics</label>
        <textarea class="form-control" id="lectureTextArea" rows="3"></textarea>
      </div>
    </form>
    
    <button class="btn btn-lg btn-primary btn-block" type="submit">Confirm</button>
    </main>

    <?php include("includes/footer.php"); ?>
  </body>
</html>