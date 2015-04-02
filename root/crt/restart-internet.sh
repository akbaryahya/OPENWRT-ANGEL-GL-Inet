#!/bin/sh
DATE=`eval date +%Y-%m-%d-%H:%M:%S`
echo -n $DATE >> /www/dial.log
echo ' <b><font color=green>Internet terkoneksi ke server OpenVPN</font></b>' >> /www/dial.log
sleep 5
while true
do
	if tail -1 /www/vpn.log | grep 'Initialization Sequence Completed'
	then
		sleep 1
	else
		
		#DATE=`eval date +%Y-%m-%d-%H:%M:%S`
		#echo -n $DATE >> /www/dial.log
		#echo ' <b><font color=red>Openvpn Disconnected. Koneksi internet direstart</font></b>' >> /www/dial.log
		
		#MENGHITUNG JUMLAH RESTART INTERNET DALAM SATU HARI
		#TANGGAL=`date +%Y-%m-%d`
		#grep "Profile :.*. Started" /www/dial.log > /www/restart
		#grep $TANGGAL /www/restart > /www/today
		#wc -l /www/today > /www/filter
		#sed 's/\/www\/today//' /www/filter > /www/print
		#COUNT=`cat /www/print`
		#echo "<b><font color=red>Your internet has been restarted $COUNT times today.</font></b>" >> /www/dial.log
		#echo '---------------------------------------------------------------------' >> /www/dial.log
		#rm /www/restart /www/today /www/filter /www/print
		
		#TANGGAL=`date +%Y-%m-%d`
		#grep "$TANGGAL.*.Profile :.*. Started" /www/dial.log >> /www/restart.log
		#COUNT=`wc -l /www/restart.log | sed 's/ \/www\/restart.log//'`
		#echo "<b><font color=red>Your internet has been restarted $COUNT times today.</font></b>" > /www/counter.log
		
		
		rm /www/vpn.log
		profile start > /dev/null 2>&1 &
		break
	fi
done