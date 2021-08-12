<?php
  session_start();

  define('CSS_PATH', 'css/'); //define bootstrap css path
  $main_css = 'main.css'; // main css filename
  $flex_css = 'flex.css'; // flex css filename
  $tableui_css = 'tableui.css'; // flex css filename


  //define all file paths
  define('REGISTER_BORROWER', 'usermgt/register_borrower.php');
  define('USERLIST', 'usermgt/userlist.php');
  define('RESOURCELIST', 'resourcemgt/resourcelist.php');  
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
              action="#digitallibrary-section" 
              style="margin:auto;max-width:1000px;margin-bottom: 2em;padding-left: 4em;padding-right: 2em;">
                <?php
                $login = $_SESSION["login"];
                $disabled = empty($_SESSION['login']) ? '' : 'disabled="true"';
                $hidden = empty($_SESSION['login']) ? '' : 'hidden="true"';
                $loginDetails =
                "
                <!-- username -->
                <input 
                style='padding: 10px;font-size: 17px;border: 1px solid grey;background: #f1f1f1;'
                class='boxsizing' type='text' placeholder='username' name='login' value='$login' $disabled >
                 <!-- password -->
                <input 
                style='padding: 10px;font-size: 17px;border: 1px solid grey;background: #f1f1f1;'
                class='boxsizing' type='password' placeholder='password' name='password' value='' $hidden>
                ";
                echo $loginDetails;
                ?>

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

                <p class='required-text' style='padding-top: 1em;padding-right: 9em;margin-bottom: 3em;'>
                  <?php
                    //for detecting empty value (search button clicked but query is empty)
                    if (isset($_POST['library-login']) && (empty($_POST['login']) ||  empty($_POST['password'])) ) {
                        $_SESSION["login"] = '';
                        session_unset();
                        if(empty($_POST['login'])){
                            echo '*username cannot be blank';
                        }
                        else if(empty($_POST['password'])){
                            echo '*password cannot be blank';
                        }
                    }
                    elseif(isset($_POST['library-login']) && !empty($_POST['login'])) {
                        $validateLogin = $_POST['login'];

                        ////////////////   validate login using SQL //////////////////
                        $query = mysqli_query($mysqli, "SELECT * FROM users WHERE username = '$validateLogin'");
                        $checkExistingUsername = mysqli_fetch_array($query);
                        //if not empty - proceed with further validation
                        if(!empty($checkExistingUsername)) {
                            $userObj = User::init($checkExistingUsername);
                            $pw = $userObj->password;
                            $type = $userObj->type;
                            if($_POST['password'] == $pw) {
                               $_SESSION["login"] = $validateLogin;
                               $_SESSION["type"] = $type;
                               //refresh UI to update session
                               header("Refresh: 0.1");
                            }
                            else {
                               $_SESSION["login"] = '';
                               $_SESSION["type"] = '';
                               session_unset();
                               echo '*incorrect password ';
                            }
                        }
                        else {
                            $_SESSION["login"] = '';
                            $_SESSION["type"] = '';
                            session_unset();
                            echo '*username does not exist or not in system';
                        }
                        ////////////////   validate login using SQL //////////////////
                    }
                    elseif(isset($_POST['library-logout'])) {
                        unset($_SESSION['login']);
                        unset($_SESSION['type']);
                        session_destroy();
                        header("Refresh: 0.1");
                    }
                  ?>
                </p>
              </form>
              <!-- login using name -->
            </section>

            <!-- signup section is only show prior to login -->
            <section id="signup-section"  style="<?php echo(empty($_SESSION['login']) ? '' : 'display: none;' ) ?>">
              <div style='margin-top:-4em;'>
                <p>
                  <span>Dont Have an account?</span>
                  <a href="<?php echo (REGISTER_BORROWER) ?>">Register</a>
                  <span>with us today!</span>
                </p>
              </div>
            </section>

            <section id="usertype-section"  style="<?php echo(empty($_SESSION['login']) ? 'display: none;' : '' ) ?>">
              <div style='margin-top:-4em;'>
                <h2 class="centerText">
                  <?php
                    $usertype = $_SESSION['type'];
                    if(isset($usertype) && $usertype == 'LIBRARIAN') {
                        echo 'Hello LIBRARIAN!';
                    }
                    else if(isset($usertype) && $usertype == 'BORROWER') {
                        echo 'Hello User!';
                    }
                    else {
                        echo 'Hello Unspecified User!';
                        echo "Please contact LIBRARIAN to resolve this issue...";
                    }
                  ?>
                </h2>
              </div>
            </section>

            <section id="digitallibrary-section" style="<?php echo(empty($_SESSION['login']) ? 'display: none;' : '') ?>">
              <h2 class="centerText">
                Select the options below:
              </h2>

              <div style="padding-bottom: 2em;text-align: center;">

                  <!-- librarian -->
                  <span style="<?php echo(($_SESSION['type']) === 'LIBRARIAN' ? '' : 'display: none;') ?>">
                    <a href="<?php echo (USERLIST) ?>">
                      <button
                        style="height: 5em;width: 20em;display: inline-block;"
                        class="bgprimarycolor"
                      >
                        View All Users
                      </button>
                    </a>
                  </span>

                  <!-- librarian -->
                  <a href="<?php echo (RESOURCELIST) ?>">
                    <button
                      style="height: 5em;width: 20em;display: inline-block;"
                      class="bgprimarycolor"
                    >
                      View All Resourses
                    </button>
                  </a>

                  <!-- normal user & librarian -->
                  <a href='math.php'>
                    <button
                      style="height: 5em;width: 20em;display: inline-block;"
                      class="bgprimarycolor"
                    >
                      View Available Resourses
                    </button>
                  </a>

                  <!-- normal user -->
                  <a href='literature.php'>
                    <button 
                     name="submit"
                     style="height: 5em;width: 20em;display: inline-block;"
                     class="bgprimarycolor"
                     type="submit"
                     value="Cancel" 
                     >
                      View Borrowed Resourses
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