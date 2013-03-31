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

CATALAN_PO_FILE=locales/ca_ES/LC_MESSAGES/messages.po
SPANISH_PO_FILE=locales/es_ES/LC_MESSAGES/messages.po
ENGLISH_PO_FILE=locales/en_US/LC_MESSAGES/messages.po

CATALAN_MO_FILE=locales/ca_ES/LC_MESSAGES/messages.mo
SPANISH_MO_FILE=locales/es_ES/LC_MESSAGES/messages.mo
ENGLISH_MO_FILE=locales/en_US/LC_MESSAGES/messages.mo

#Compile
echo "Compiling $CATALAN_PO_FILE..."
msgfmt -v -c --statistics -o $CATALAN_MO_FILE $CATALAN_PO_FILE
echo "Compiling $SPANISH_PO_FILE..."
msgfmt -v -c --statistics -o $SPANISH_MO_FILE $SPANISH_PO_FILE
echo "Compiling $ENGLISH_PO_FILE..."
msgfmt -v -c --statistics -o $ENGLISH_MO_FILE $ENGLISH_PO_FILE