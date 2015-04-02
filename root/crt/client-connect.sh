#!/bin/sh
/root/crt/restart-internet.sh > /dev/null 2>&1 &
date > openvpn-notification
echo "OPENVPN CONNECTED" >> openvpn-notification
echo "Selamat internetan gratis sepuasnya :D" >> openvpn-notification
echo "" >> openvpn-notification
echo -ne "Free ROM: " >> openvpn-notification
df -h / | tail -1 | awk '{print $4}' >> openvpn-notification
echo -ne "Free RAM: " >> openvpn-notification
cat /proc/meminfo | awk '/MemFree/ {print $2,$3}' >> openvpn-notification
echo -ne "Free Mem: " >> openvpn-notification
df -h /mnt/usb | tail -1 | awk '{print $4}' >> openvpn-notification
#echo "-----------------------------------" >> /tmp/gnokii.log
#chmod 744 /tmp/gnokii.log
#cat openvpn-notification >> /tmp/gnokii.log
#echo "$(cat openvpn-notification)" | gnokii --sendsms 085642383165 2>> /tmp/gnokii.log

FILE=`mktemp /tmp/send_XXXXXX`
echo "To: 085642383165" > $FILE
echo "" >> $FILE
cat openvpn-notification >> $FILE
FILE2=`mktemp /var/spool/sms/outgoing/openvpn-client-connect_XXXXXX`
mv $FILE $FILE2
rm openvpn-notification