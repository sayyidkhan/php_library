<?php
  session_start();

  define('CSS_PATH', 'css/'); //define bootstrap css path
  $main_css = 'main.css'; // main css filename
  $flex_css = 'flex.css'; // flex css filename
  $tableui_css = 'tableui.css'; // flex css filename
?>

<!-- database -->
<?php
//including the database connection file
include_once("config.php");

//adding the user class
include 'classes/user.php';
?>

<!-- perform query -->
<?php
$query = mysqli_query($mysqli, "SELECT * FROM users ORDER BY id DESC");

?>

<!DOCTYPE html>
<html>
  
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Takoko Digital Library</title>
    <!-- main CSS-->
    <link rel="stylesheet" href='<?php echo (CSS_PATH . "$main_css"); ?>' type="text/css">
    <link rel="stylesheet" href='<?php echo (CSS_PATH . "$flex_css"); ?>' type="text/css">
    <link rel="stylesheet" href='<?php echo (CSS_PATH . "$tableui_css"); ?>' type="text/css">

  </head>
  <body>

      <div id="wrapper">

        <div id="header">
          <h1>Takoko Digital Library</h1>
        </div>

        <div id="content">

           <section id='login-section'>
            <h3 class="centerText primarycolor">Welcome to Takoko Digital Library. Enter your login details to proceed</h3>

            <div class="container">
              <form 
              method='post'
              name='login-name'
              class="boxsizing"
              action="#quizselection-section" 
              style="margin:auto;max-width:1000px;margin-bottom: 2em;padding-left: 4em;padding-right: 2em;">
                <?php
                $login = $_SESSION["login"];
                $disabled = empty($_SESSION['login']) ? '' : 'disabled="true"';
                $bikesearchQuery =
                "<input 
                style='padding: 10px;font-size: 17px;border: 1px solid grey;background: #f1f1f1;'
                class='boxsizing' type='text' placeholder='username' name='login' value='$login' $disabled >";
                echo $bikesearchQuery;
                ?>
                
                <input 
                style='padding: 10px;font-size: 17px;border: 1px solid grey;background: #f1f1f1;'
                class='boxsizing' type='password' placeholder='password' name='password' value='' >

                <!-- logout button -->
                <button 
                style='padding: 10px;' 
                name='library-logout' class="librarybutton boxsizing " type="submit" value='logout'
                <?php echo empty($_SESSION['login']) ? 'disabled="true" style="background-color: #C0C0C0;pointer-events: none;"' : ''; ?>
                >logout</button>
                <!-- logout button -->

                <!-- login button -->
                <button
                style='padding: 10px;' 
                name='library-login' class="boxsizing lightbluecolor" type="submit" value='submit'
                <?php echo empty($_SESSION['login']) ? '' : 'disabled="true" style="background-color: #C0C0C0;pointer-events: none;"'; ?>
                >login</button>
                <!-- login button -->

                <p class='required-text' style='padding-top: 1em;padding-right: 9em;'>
                  <?php
                    //for detecting empty value (search button clicked but query is empty)
                    if (isset($_POST['library-login']) && empty($_POST['login'])) {
                        $_SESSION["login"] = '';
                        session_unset();
                        echo '*login cannot be blank'; 
                    }
                    elseif(isset($_POST['library-login']) && !empty($_POST['login'])) {
                        $validateLogin = $_POST['login'];
                        $loginStatus = false;

                        //validate login


                        //if login status is successful
                        if($loginStatus) { 
                           $_SESSION["login"] = $validateLogin;
                           //refresh UI to update session
                           header("Refresh: 0.1");
                        }
                        else {
                           $_SESSION["login"] = '';
                           session_unset();
                           echo '*name does not exist or not in system';
                        }
                    }
                    elseif(isset($_POST['library-logout'])) {
                        unset($_SESSION['overallScore']); // unset overall score
                        session_destroy();
                        header("Refresh: 0.1");
                    }
                  ?>
                </p>
              </form>
              <!-- login using name -->
            </section>

            <section id="quizselection-section" style="<?php echo(empty($_SESSION['login']) ? 'display: none;' : '') ?>">
              <h2 class="centerText">
                Select the quiz you would like to take:
              </h2>

              <div style="padding-bottom: 2em;text-align: center;">

                  <a href='math.php'>
                    <button
                      name="submit"
                      style="height: 5em;width: 20em;display: inline-block;"
                      class="bgprimarycolor"
                      type="submit"
                      value="Save"
                    >
                      Math
                    </button>
                  </a>

                  <a href='literature.php'>
                    <button 
                     name="submit"
                     style="height: 5em;width: 20em;display: inline-block;"
                     class="bgprimarycolor"
                     type="submit"
                     value="Cancel" 
                     >
                      Literature
                     </button>
                  </a>

                  <p id="saved"></p>

               </div>
             </section>

          </div>
        </div>

        <div id="footer">
          <p>
            &copy;
            <?php 
            $currentYear = date('Y'); 
            echo $currentYear; 
            ?>
            All rights reserved.
          </p>
        </div>

    </div>


  </body>
</html>