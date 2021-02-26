<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link href="css/style.css" rel="stylesheet">
    <title>Bookup: Home</title>
  </head>

  <body>
    <header role="banner">
      <!-- <img src="media/"> -->
      <h1>Bookup: The Book Lookup Tool</h1>
      <nav role="navigation">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li class="dropdown">
            <a class="dropbtn">Subjects</a>
            <ul class="dropdown-content">
              <a href="subject.php">Fantasy</a>
              <a href="subject.php">Science Fiction</a>
              <a href="subject.php">Historical</a>
            </ul>
          </li>
          <li><a href="#" class="current-page">My Bookshelf</a></li>
        </ul>
        <div>
          <a class="login">Log In</a>
          <form>
            <label for="search">Search:</label>
            <input type="text" id="search" name="search">
            <label for="search-type">By:</label>
            <select id="search-type" name="search-type">
              <option value="title">Title</option>
              <option value="category">Category</option>
              <option value="author">Author</option>
              <option value="publisher">Publisher</option>
              <option value="isbn">ISBN</option>
            </select>
            <input type="submit" value="Search">
          </form>
        </div>
      </nav>
    </header>
    <main>
      <h1>Your Bookshelf</h1>
    </main>
  </body>
</html>
