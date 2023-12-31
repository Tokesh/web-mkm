<?php
// Assuming you have a file named 'db.php' that handles the database connection
require 'db.php';

try {
    // Prepare the SQL statement to select posts
    $stmt = $pdo->prepare("SELECT p.text, p.media_link, u.name, u.profile_description 
                            FROM post AS p 
                            JOIN users AS u ON p.user_id = u.user_id 
                            ORDER BY p.post_id DESC");
    $stmt->execute();

    // Fetch all posts as an associative array
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home / X</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <section>
        <!-- Это левая панелька -->
        <div class="main-left-bar">
            <div class="main-left-bar-1">
                <ul>
                    <li><a href="home.html"><img src="images/x-logo.png" alt="x-logo" width="30px"></a></li>
                    <li><a href="home.html"><img src="images/home.png" alt="home" width="30px">Home</a></li>
                    <li><a href="explore.html"><img src="images/find.png" alt="explore" width="30px">Explore</a></li>
                    <li><a href="notifications.html"><img src="images/notifications.png" alt="notifications" width="30px">Notifications</a></li>
                    <li><a href="messages.html"><img src="images/messages.png" alt="messages" width="30px">Messages</a></li>
                    <li><a href="lists.html"><img src="images/lists.png" alt="lists" width="30px">Lists</a></li>
                    <li><a href="communities.html"><img src="images/communities.png" alt="communities" width="30px">Communities</a></li>
                    <li><a href="#"><img src="images/x.png" alt="premium" width="30px">Premium</a></li>
                    <li><a href="profile.html"><img src="images/profile.png" alt="profile" width="30px">Profile</a></li>
                    <li><a href="#"><img src="images/more.png" alt="more" width="30px">More</a></li>
                </ul>
                <button style="background: dodgerblue;height: 50px;width: 100%;border: none;font-size: 20px;color: white;font-weight: bold;border-radius: 30px;">Post</button>
            </div>
            <div class="main-left-bar-2">
                <img src="images/avatar.jpg" alt="avatar" width="50px" style="border-radius: 50px;">
                <div class="main-left-bar-2-text">
                    <h4 style="color: white">Kan</h4>
                    <h4 style="color: grey">@Kanres</h4>
                </div>
            </div>
        </div>


        <div class="main-middle-content">
            <div class="main-middle-new-post">
                <h1 style="color: white;margin-left: 2vw;">Home</h1>
                <div style="display: flex;font-size: 18px;font-weight: bold;border-bottom: 1px solid rgb(101, 101, 101);justify-content: space-around;">
                    <a href="#"><p style="color: white;border-bottom: 5px solid dodgerblue;">For you</p></a>
                    <a href="#"><p style="color: grey">Following</p></a>
                </div>
            </div>
            <div class="main-middle-whats-happening">
                <div class="main-profile-pic">
                    <img src="images/avatar.jpg" alt="avatar" width="40px" style="border-radius: 50px;">
                </div>
                <div class="main-input">
                    <select name="where-to-post" id="everyone-private" style="border: 1px solid rgba(30, 143, 255, 0.541);background: black;color: dodgerblue;  border-radius: 50px; height: 25px;font-size: 16px;width: 100px;">
                        <option value="Everyone" style="padding: 0 10vw;">Everyone</option>
                        <option value="Private">Private</option>
                    </select>
                    <input type="text" name="post" id="new-post" placeholder="What is happening?!" style="font-size: 22px;border: none;background: black;height: 10vh;color: white;">
                    <h4 style="color: dodgerblue; font-weight: bold;"><img src="images/globe.png" alt="globe" width="16px"> Everyone can reply</h4>
                    <div class="main-input-bottom">
                        <div class="main-input-icons">
                            <div class="main-input-icon"><img src="images/gallery.png" alt="gallery"></div>
                            <div class="main-input-icon"><img src="images/gif.png" alt="gif"></div>
                            <div class="main-input-icon"><img src="images/poll.png" alt="poll"></div>
                            <div class="main-input-icon"><img src="images/emoji.png" alt="emoji"></div>
                            <div class="main-input-icon"><img src="images/calendar.png" alt="calendar"></div>
                            <div class="main-input-icon"><img src="images/geo.png" alt="geo"></div>
                        </div>
                        <button style="background: dodgerblue;height: 30px;width: 5vw;border: none;font-size: 18px;color: white;font-weight: bold;border-radius: 30px;">Post</button>
                    </div>
                    
                </div>
            </div>
            <div class="main-news-feed">
                <?php foreach ($posts as $post): ?>
                    <div class="post">
                        <h3><?= htmlspecialchars($post['name']) ?></h3>
                        <p><?= nl2br(htmlspecialchars($post['text'])) ?></p>
                        <?php if ($post['media_link']): ?>
                            <img src="<?= htmlspecialchars($post['media_link']) ?>" alt="Media">
                        <?php endif; ?>
                        <p><?= htmlspecialchars($post['profile_description']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="main-right-bar">
            <div class="main-right-bar-search">
                <img src="images/find.png" alt="search" width="24px" height="24px">
                <input type="text" placeholder="Search" style="border: none; background: rgb(47, 47, 47);height: 40px;font-size: 16px;border-radius: 50px;width: 100%;color: white;">
            </div>
            <div class="main-right-bar-premium">
                <h2 style="color: white;">Subscribe to Premium</h2>
                <h4 style="color: white;">Subscribe to unlock new features and if eligible, receive a share of ads revenue.</h4>
                <a href="premium.html" style="width: 7vw;"><button style="background: dodgerblue;height: 30px;width: 7vw;border: none;font-size: 16px;color: white;font-weight: bold;border-radius: 30px;cursor: pointer;;">Subscribe</button></a>
            </div>

            <div class="trending">
                <h1 style="color: white;padding: 1vw 0 0 1vw;">Trends for you</h1>
                <div class="trends-box">
                    <div class="trends-item">
                        <p style="color: gray;font-size: 14px;">News • Trending</p>
                        <h4 style="color: white;">Hamas</h4>
                        <p style="color: grey;font-size: 14px;">2.72M posts</p>
                    </div>

                    <div class="trends-item">
                        <p style="color: gray;font-size: 14px;">Only on Twitter • Trending</p>
                        <h4 style="color: white;">#TheAmazingDigitalCircus</h4>
                        <p style="color: grey;font-size: 14px;">119K posts</p>
                    </div>

                    <div class="trends-item">
                        <p style="color: gray;font-size: 14px;">News • Trending</p>
                        <h4 style="color: white;">Israel</h4>
                        <p style="color: grey;font-size: 14px;">6.96M posts</p>
                    </div>

                    <div class="trends-item">
                        <p style="color: gray;font-size: 14px;">Trending in Kazakhstan</p>
                        <h4 style="color: white;">Ризли</h4>
                    </div>

                    <div class="trends-item">
                        <p style="color: gray;font-size: 14px;">Trending in Kazakhstan</p>
                        <h4 style="color: white;">China</h4>
                        <p style="color: grey;font-size: 14px;">358K posts</p>
                    </div>

                    <div class="trends-item">
                        <a href="#" style="color: dodgerblue;font-size: 16px;font-weight: bold;">Show more</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>