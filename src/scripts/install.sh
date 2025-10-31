#!/bin/bash

# Script de instalación
echo "Instalando extensión de monitoreo..."

# Verificar que estamos en Plesk
if [ ! -d "/usr/local/psa/admin" ]; then
    echo "Error: No se encuentra Plesk"
    exit 1
fi

# Crear directorio para la extensión
EXT_DIR="/usr/local/psa/admin/plib/modules/server-monitor"
mkdir -p $EXT_DIR

echo "Instalación completada"
exit 0