<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/signup.css">
    <link rel="icon" href="images/x-logo.png">
    <title>X. Главное происходит здесь. / X</title>
</head>
<body>
    
<?php
// Include database connection file
require_once 'db.php';

// Start the session
session_start();

// Define variables and initialize with empty values
$username = $password = $confirm_password = $name = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (isset($_POST["signup"])) {
        if (empty(trim($_POST["username"]))) {
            $username_err = "Пожалуйста, введите логин.";
        } else {
            // Prepare a select statement
            $sql = "SELECT user_id FROM users WHERE login = ?";
            
            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                
                // Set parameters
                $param_username = trim($_POST["username"]);
                
                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Store result
                    mysqli_stmt_store_result($stmt);
                    
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        $username_err = "Этот логин уже занят.";
                    } else {
                        $username = trim($_POST["username"]);
                    }
                } else {
                    echo "Упс! Что-то пошло не так. Пожалуйста, попробуйте позже.";
                }
    
                // Close statement
                mysqli_stmt_close($stmt);
            }
        }
        
        // Validate password
        if (empty(trim($_POST["password"]))) {
            $password_err = "Пожалуйста, введите пароль.";     
        } elseif (strlen(trim($_POST["password"])) < 6) {
            $password_err = "Пароль должен содержать не менее 6 символов.";
        } else {
            $password = trim($_POST["password"]);
        }
        
        // Validate confirm password
        if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Пожалуйста, подтвердите пароль.";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($password_err) && ($password != $confirm_password)) {
                $confirm_password_err = "Пароли не совпадают.";
            }
        }
        
        // Check input errors before inserting in database
        if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
            
            // Prepare an insert statement
            $sql = "INSERT INTO users (login, password, name) VALUES (?, ?, ?)";
             
            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_name);
                
                // Set parameters
                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                $param_name = trim($_POST["name"]); // Assuming you're also getting a name field from the form
                
                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Redirect to login page
                    header("location: home.php");
                } else {
                    echo "Упс! Что-то пошло не так. Пожалуйста, попробуйте позже.";
                }
    
                // Close statement
                mysqli_stmt_close($stmt);
            }
        }
    }
    if (isset($_POST["login"])) {
        // Validate login credentials
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        // Prepare a select statement to check if the username exists
        $sql = "SELECT user_id, login, password FROM users WHERE login = ?";
        
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $user_id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $user_id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to home page
                            header("location: home.php");
                        } else {
                            // Display an error message if password is not valid
                            $login_err = "Неверный пароль.";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $login_err = "Нет аккаунта с таким логином.";
                }
            } else {
                echo "Упс! Что-то пошло не так. Пожалуйста, попробуйте позже.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    
    // Close connection
    mysqli_close($link);
}
?>

    <div class="main-content">
        <div class="left-side-logo">
            <img src="images/x-logo.png" alt="x logo" width="100%">
        </div>
        <div class="right-side-signup">
            <div class="right-side-top-text">
                <h1>В курсе происходящего</h1>
                <h4>Присоединяйтесь сегодня.</h4>
            </div>
            <div class="signup-btns">
                <a href="#">
                    <div class="signup-btn">
                        <p style="color: black"><img src="images/avatar.jpg" alt="avatar" width="20vw" style="border-radius: 15px;"> Войти через аккаунт Google</p>
                        <img src="images/google-logo.png" alt="google-logo" width="20vw">
                    </div>
                </a>
                <a href="#">
                    <div class="signup-btn">
                        <p style="color: black; font-weight: bold;"><img src="images/apple-logo.png" alt="apple logo" width="20vw">Зарегистрироваться с Apple ID</p>
                    </div>            
                </a>
            </div>

            <hr>
            <div class="hr-text">
                <p style="color: grey;background-color: black;z-index: 1; display: flex; ;">ИЛИ</p>
            </div>
            <button id="signup" style="width: 20vw;border: none;height:6vh;background-color:deepskyblue;color: white;font-size: 16px;font-weight: bold;border-radius: 20px;cursor: pointer;">Зарегистрироваться</button>
            <p style="margin-bottom:50px;font-size: 11px;color: grey;width: 20vw;">Регистрируясь, вы соглашаетесь с <a href="#" style="color:dodgerblue;">Условиями предоставления услуг</a> и <a href="#" style="color: dodgerblue;">Политикой конфиденциальности</a>, а также с <a href="#" style="color: dodgerblue;">Политикой использования файлов cookie.</a></p>
            <h4 style="margin-bottom: 3vh;">Уже зарегистрированы?</h4>
            <!-- <a> тут временный -->
            <button id="login" style="width: 20vw;border: 1px solid grey;height:6vh;background-color:black;color: dodgerblue;font-size: 16px;font-weight: bold;border-radius: 20px;cursor: pointer;">Войти</button>
            <!--  -->
        </div>
    </div>
    <footer>
        <ul>
            <li><a href="#">О нас</a></li>
            <li><a href="#">Скачать приложение Х</a></li>
            <li><a href="#">Справочный центр</a></li>
            <li><a href="#">Условия предоставления услуг</a></li>
            <li><a href="#">Политика конфиденциальности</a></li>
            <li><a href="#">Политика в отношении файлов cookie</a></li>
            <li><a href="#">Специальные возможности</a></li>
            <li><a href="#">Информация о рекламе</a></li>
            <li><a href="#">Блог</a></li>
            <li><a href="#">Статус</a></li>
            <li><a href="#">Работа</a></li>
            <li><a href="#">Ресурсы бренда</a></li>
            <li><a href="#">Реклама</a></li>
            <li><a href="#">Маркетинг</a></li>
            <li><a href="#">Х для бизнеса</a></li>
            <li><a href="#">Разработчикам</a></li>
            <li><a href="#">Каталог</a></li>
            <li><a href="#">Настройки</a></li>
            <li>© 2023 X Corp.</li>
        </ul>
    </footer>
    <div class="popup-register" id="regPopup">
        <div class="popup-register-box">
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="popup-register-form">
            <a href="#" id="closeRegBtn" style="position: absolute; top: 25px; left: 50px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; color: white; font-weight: 100;">
                    <h1>X</h1>
                </a>
                <div class="popup-register-form-1">
                    <h2>Создайте учетную запись</h2>
                    <input type="text" name="name" placeholder="Имя" class="input-form" value="<?php echo $name; ?>" required>
                    <input type="text" name="username" placeholder="Логин" class="input-form" value="<?php echo $username; ?>" required>
                    <span class="error-message"><?php echo $username_err; ?></span>
                    
                    <input type="password" name="password" placeholder="Пароль" class="input-form" required>
                    <span class="error-message"><?php echo $password_err; ?></span>
                    <input type="password" name="confirm_password" placeholder="Подтвердите пароль" class="input-form" required>
                    <span class="error-message"><?php echo $confirm_password_err; ?></span>
                </div>

                <div class="popup-register-form-2">
                <h2>Дата рождения</h2>

                    <p>Эта информация не будет общедоступной. Подтвердите свой возраст, даже если эта учетная запись предназначена для компании, домашнего животного и т.д.</p>
                    <div class="popup-register-form-ddmmyy">
                        <select name="day" id="select-d" class="input-form">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                            <option value="31">31</option>
                            
                        </select>
                        <select name="month" id="select-m" class="input-form">
                            <option value="jan">Январь</option>
                            <option value="feb">Февраль</option>
                            <option value="mar">Март</option>
                            <option value="apr">Апрель</option>
                            <option value="may">Май</option>
                            <option value="jun">Июнь</option>
                            <option value="jul">Июль</option>
                            <option value="aug">Август</option>
                            <option value="sep">Сентябрь</option>
                            <option value="oct">Октябрь</option>
                            <option value="nov">Ноябрь</option>
                            <option value="dec">Декабрь</option>
                            
                        </select>
                        <select name="year" id="select-y" class="input-form">
                            <option value="2007">2007</option>
                            <option value="2006">2006</option>
                            <option value="2005">2005</option>
                            <option value="2004">2004</option>
                            <option value="2003">2003</option>
                            <option value="2002">2002</option>
                            <option value="2001">2001</option>
                            <option value="2000">2000</option>
                            <option value="1999">1999</option>
                            <option value="1998">1998</option>
                            <option value="1997">1997</option>
                            <option value="1996">1996</option>
                            <option value="1995">1995</option>
                            <option value="1994">1994</option>
                            <option value="1993">1993</option>
                            <option value="1992">1992</option>
                            <option value="1991">1991</option>
                            <option value="1990">1990</option>
                            <option value="1989">1989</option>
                            <option value="1988">1988</option>
                            <option value="1987">1987</option>
                            <option value="1986">1986</option>
                            <option value="1985">1985</option>
                            <option value="1984">1984</option>
                            <option value="1983">1983</option>
                            <option value="1982">1982</option>
                            <option value="1981">1981</option>
                            <option value="1980">1980</option>
                            <option value="1979">1979</option>
                            <option value="1978">1978</option>
                            <option value="1977">1977</option>
                            <option value="1976">1976</option>
                            <option value="1975">1975</option>
                            <option value="1974">1974</option>
                            <option value="1973">1973</option>
                            <option value="1972">1972</option>
                            <option value="1971">1971</option>
                            <option value="1970">1970</option>
                            <option value="1969">1969</option>
                            <option value="1968">1968</option>
                            <option value="1967">1967</option>
                        </select>
                    </div>
                </div>
                <button type="submit" name="signup" style="border-radius: 25px; background: white; width: 25vw; height: 50px; cursor: pointer; font-size: 18px;">Регистрация</button>
                </form>
            </div>
            
        </div>
    </div>
    <div class="popup-login">
    <div class="popup-login-box">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="popup-login-form">
                <a href="#" id="closeLogBtn" style="position: absolute; top: 15px; left: 20px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; color: white; font-weight: 100; font-size: 10px;">
                    <h1>X</h1>
                </a>
                <h1>Вход в Х</h1>
            <div class="popup-login-btns">
                <a href="#">
                    <div class="signup-btn">
                        <p style="color: black"><img src="images/avatar.jpg" alt="avatar" width="20vw" style="border-radius: 15px;"> Войти через аккаунт Google</p>
                        <img src="images/google-logo.png" alt="google-logo" width="20vw">
                    </div>
                </a>
                <a href="#">
                    <div class="signup-btn">
                        <p style="color: black; font-weight: bold;"><img src="images/apple-logo.png" alt="apple logo" width="20vw">Зарегистрироваться с Apple ID</p>
                    </div>            
                </a>
            </div>
            <div class="line-or">
                <hr style="width: 10vw;">
                <p style="color: grey;">ИЛИ</p>
                <hr style="width: 10vw;">
            </div>

            <input type="text" name="username" placeholder="Логин" class="input-form" required>
                <input type="password" name="password" placeholder="Пароль" class="input-form" required>
                <button type="submit" name="login" style="border-radius: 25px; background: white; width: 25vw; height: 50px; cursor: pointer; font-size: 18px;">Войти</button>
               
            <p>Нет учётной записи? <span style="color: dodgerblue;">Зарегистрируйтесь</span></p>
        </form>
    </div>
</div>

    <script src="js/popup-reg.js"></script>
</body>
</html>