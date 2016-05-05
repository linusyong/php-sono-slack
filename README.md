# php-sono-slack
=========
1. The php script depends on [sonos-PHP-class](https://github.com/DjMomo/sonos)
2. You can run this using tmux:
    ```
    $ tmux new -d -s sono-slack "/usr/bin/php php-sono-slack/sonos-slack.php"
    ```
3. To connect back to the tmux session use:
    ```
    $ tmux att -t sono-slack
    ```
