<!-- navbar -->
<div>
  <nav class="nav dark-nav">
    <div class="container">
      <div class="nav-heading">
        <button class="toggle-nav" data-toggle="open-navbar1"><i class="fa fa-align-right"></i></button>
        <a class="brand" href="/">Fu Jen Catholic University</a>
      </div>
      <div class="menu" id="open-navbar1">
			<ul class="list">
				<li><a href="/">教室預借紀錄</a></li>
        <?php
          if (!empty($_SESSION['nickname'])) {
            echo "<li><a>".$_SESSION['nickname']."</a></li>";
            echo "<li><a href='/record.php'>個人預借紀錄</a></li>";
            echo "<li><a href='/reserve.php'>預借教室</a></li>";
            echo "<li><a href='/logout.php'>登出</a></li>";
          } else { echo "<li><a href='/login.php'>登入</a></li>"; }; 
          if (!empty($_SESSION['permission']) && $_SESSION['permission'] == 'admin') {
            echo "<li><a href='/semestertool.php'>學期期間管理工具</a></li>";
            echo "<li><a href='/admintool.php'>管理者工具</a></li>";
          };
        ?>
			</ul>
      </div>
    </div>
  </nav>
</div>
