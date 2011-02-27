#! /bin/sh
#
# MSN bot
#

NAME=msnbot
DESC="MSN bot"

set -e

case "$1" in
  start)
	echo -n "Starting $DESC: $NAME"
	/var/spool/msnbot/msnbot.php
	echo "."
	;;
  stop)
	echo -n "Stopping $DESC: $NAME"
    MSNPID=`cat /var/spool/msnbot/log/msnbot.pid`
	kill $MSNPID
	echo "."
	;;
  restart|force-reload)
	$0 stop
	sleep 5s
	$0 start
	;;
  *)
	N=/etc/init.d/$NAME
	echo "Usage: $N {start|stop|restart|force-reload}" >&2
	exit 1
	;;
esac

exit 0
