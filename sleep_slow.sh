#!/usr/bin/env bash
#short cut created by 
#sudo ln -s /var/www/vhosts/utils/utils_repo/sleep_slow.sh /bin/sleep_slow
#for a laptop it sleeps/awakes properly if sleep is triggered on lock screen
#observe that few times that when it goes to lock screen mode
#and after many minutes I take out power, it goes to sleep (inactivity+no power)
#then it wakes up properly otherwise it does not wake up
if [[ $EUID -ne 0 ]]; then
  echo "not root so running in sudo"
  sudo sleep_slow 
  exit 1
fi
sudo echo "will lock your screen and put computer to sleep"
sudo sleep 2s
gnome-screensaver-command -l
sudo sleep 8s
sudo systemctl suspend

