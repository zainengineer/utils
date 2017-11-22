#!/usr/bin/env bash
#short cut created by 
#sudo ln -s /var/www/vhosts/utils/utils_repo/sleep_slow.sh /bin/sleep_slow
#for a laptop it sleeps/awakes properly if sleep is triggered on lock screen
#observe that few times that when it goes to lock screen mode
#and after many minutes I take out power, it goes to sleep (inactivity+no power)
#then it wakes up properly otherwise it does not wake up
sudo sleep 20s
sudo systemctl suspend

