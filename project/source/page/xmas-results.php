<?php
require_once '../action/xmas-authenticate.php';
require_once '../data/xmas-participant.php';
$drawn = include '../action/xmas-was-lottery-drawn.php';
if (!$drawn) {
  $_SESSION["notifications"] = [new Notification(NotificationText::NoPermission, NotificationLevel::Error)];
  http_response_code(403);
  include "../page/landing.php";
  exit;
}
$user = XmasParticipant::get_from_code($_SESSION["xmas"]);
?>
<!DOCTYPE html>
<html>
  <?php define('TITLE', 'Lottery Results!'); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'header.php'; ?>
    <?php include 'notification-box.php'; ?>
    <div class="center">
      <div id="hidden" style="display: none;">
        <div id="winning-numbers" class="widget" style="padding: 1em; border-radius: 2em; background-color: #00ff490d; margin: 1em; margin-top: 2em;">
          <h1 style="background-color: purple;">Winning Numbers</h1>
          <span id="drumroll" class="lottery-bullet"><span class="lottery-number">🥁</span></span>
        </div>
        <div id="your-ticket" class="widget" style="display: inline-block; padding: 1em; border-radius: 2em; margin: 1em;">
          <span style="display: inline-block; background: linear-gradient(92deg, #edb, #fc6 94%, #ffc 96.5%, #feb 97%, #fda); border: solid 2px rgba(105, 100, 90, 0.3); vertical-align: bottom; border-radius: 1em; padding: 0.5em 0;">
            <div style="position: relative;">
              <img style="position: absolute; top: -1.6em; left: 0.2em; width: 64px;" src="/page/img/lotto-gold.png">
              <h2 class="ticket-owner"><?php echo ucwords(strtolower($user->name)); ?>'s Lottery Ticket</h2>
            </div>
            <div style="margin: 1em 2em;">
              <?php
                $ticket_numbers = include '../action/xmas-get-lottery-ticket.php';
                foreach (array_values($ticket_numbers) as $i => $num) {
                  echo "<span class='lottery-bullet'><span id='lottery-number-".$i."' class='lottery-number'>".$num."</span></span>";
                }
              ?>
            </div>
          </span>
        </div>
        <?php include 'xmas-prizes.php' ?>
      </div>
      <div id="trigger">
        <a class="link" href="#reveal" onclick="reveal();"><img class="anticipation" src="/page/img/present.svg" /></a>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
    <script>
      function reveal() {
        document.getElementById("trigger").style.display = "none";
        document.getElementById("hidden").style.display = "block";
        const initialPause = 1200;
        const duration = 1500;
        const winningNumbers = <?php echo json_encode(include '../action/xmas-get-winning-ticket.php'); ?>;
        const revealSfx = new Audio("/page/audio/reveal.ogg");
        revealSfx.volume = 0.8;
        const winningNumberElements = [];
        const commands = winningNumbers.map((number) => function() {
          const lotteryBullet = document.createElement("span");
          lotteryBullet.classList.add("lottery-bullet");
          lotteryBullet.classList.add("winning");
          lotteryBullet.classList.add("zoom-out");
          const lotteryNumber = document.createElement("span");
          lotteryNumber.classList.add("lottery-number");
          lotteryNumber.innerText = number;
          winningNumberElements.push(lotteryNumber);
          lotteryBullet.appendChild(lotteryNumber);
          document.getElementById("winning-numbers").appendChild(lotteryBullet);
          revealSfx.play();
        });
        const openSfx = new Audio("/page/audio/open.ogg");
        commands.push(function() {
          const count = 7;
          const yourNumberElements = [...Array(count).keys()].map((num) => document.getElementById(`lottery-number-${num}`));
          let i = 0;
          const colours = [
            "lime",
            "aqua",
            "blue",
            "darkviolet",
            "fuchsia",
            "coral",
            "goldenrod",
          ]
          for (const a of winningNumberElements) {
            for (const b of yourNumberElements) {
              if (a.innerText == b.innerText) {
                [a, b].forEach((elem) => elem.parentElement.style.outline = `solid ${colours[i]}`);
                i++;
              }
            }
          }
          if (winningNumbers.some((winner) => yourNumberElements.map((elem) => elem.innerText).includes(winner.toString()))) {
            const gagnantSfx = new Audio("/page/audio/winner.ogg");
            gagnantSfx.play();
            openSfx.play();
            confetti();
          }
        });
        setTimeout(function() {
          document.getElementById("drumroll").remove();
          // Immediately pop first command so that standin is removed at the exact same time
          commands.shift()();
          for (const [i, command] of commands.entries()) {
            setTimeout(command, duration * i + duration);
          }
        }, initialPause);
        openSfx.play();
        const drumSfx = new Audio("/page/audio/timpani.ogg");
        drumSfx.play();
        confetti();
      }
    </script>
  </body>
</html>