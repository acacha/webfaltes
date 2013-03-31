# webfaltes - https://sourceforge.net/projects/webfaltes/
# Copyright (c) 2010, Sergi Tur Badenas _Carles Añó
# Coautors: Pau Gómez 
#
# This library is free software; you can redistribute it and/or modify it under
# the terms of the GNU Lesser General Public License as published by the Free
# Software Foundation; either version 2.1 of the License, or (at your option)
# any later version.
# 
# This library is distributed in the hope that it will be useful, but WITHOUT
# ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
# FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more
# details.
# 
# You should have received a copy of the GNU Lesser General Public License
# along with this library; if not, write to the Free Software Foundation, Inc.,
# 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA
# http://www.fsf.org/licensing/licenses/lgpl.txt

#!/bin/bash
#Smarty gettext
php libs/smarty-gettext/tsmarty2c.php smarty/templates > smarty_messages.c

#Extract text from smarty and php code
xgettext --from-code=utf-8 --package-name=webfaltes --package-version 1.0 --msgid-bugs-address=sergi.tur@upc.edu -kT_ngettext:1,2 -kT_ -o messages_new.po smarty_messages.c *.php includes/*.php javascript/calendar.php

#Establir paràmetres de la plantilla:
sed -i s/SOME\ DESCRIPTIVE\ TITLE/Webfaltes\ po\ file/ messages_new.po
sed -i s/FIRST\ AUTHOR/Sergi\ Tur/ messages_new.po
sed -i s/YEAR/2009/ messages_new.po
sed -i s/THE\ PACKAGE\'S\ COPYRIGHT\ HOLDER/Sergi\ Tur\ Badenas/ messages_new.po
sed -i s/PACKAGE/webfaltes/ messages_new.po
sed -i s/charset=CHARSET/charset=UTF-8/ messages_new.po
sed -i s/FULL\ NAME/Sergi\ Tur/ messages_new.po
sed -i s/EMAIL@ADDRESS/sergi.tur@upc.edu/ messages_new.po

mv messages_new.po messages_new.pot

#Message init is not useful here
#msginit -o messages_new.po 

CATALAN_PO_FILE=locales/ca_ES/LC_MESSAGES/messages.po
SPANISH_PO_FILE=locales/es_ES/LC_MESSAGES/messages.po
ENGLISH_PO_FILE=locales/en_US/LC_MESSAGES/messages.po

#Catalan
if [ -f $CATALAN_PO_FILE ];
then
 echo "Updating $CATALAN_PO_FILE..."
 msgmerge -v $CATALAN_PO_FILE messages_new.pot -U
else
 echo "Creating new file $CATALAN_PO_FILE..."
 cp messages_new.pot $CATALAN_PO_FILE
fi

#Spanish
if [ -f $SPANISH_PO_FILE ];
then
 echo "Updating $SPANISH_PO_FILE..."
 msgmerge -v $SPANISH_PO_FILE messages_new.pot -U
else
 echo "Creating new file $SPANISH_PO_FILE..."
 cp messages_new.pot $SPANISH_PO_FILE
fi

#English
if [ -f $ENGLISH_PO_FILE ];
then
 echo "Updating $ENGLISH_PO_FILE..."
 msgmerge -v $ENGLISH_PO_FILE messages_new.pot -U
else
 echo "Creating new file $ENGLISH_PO_FILE..."
 cp messages_new.pot $ENGLISH_PO_FILE
fi

echo "Now you can translate po files..."

#Compile
msgfmt -v -c --statistics -o locales/ca_ES/LC_MESSAGES/messages.mo locales/ca_ES/LC_MESSAGES/messages.po
msgfmt -v -c --statistics -o locales/es_ES/LC_MESSAGES/messages.mo locales/es_ES/LC_MESSAGES/messages.po
msgfmt -v -c --statistics -o locales/en_US/LC_MESSAGES/messages.mo locales/en_US/LC_MESSAGES/messages.po
