# Configurar HTTPS en XAMPP para PWA Testing

## Pasos para habilitar HTTPS en XAMPP:

### 1. Activar SSL en Apache
- Abrir XAMPP Control Panel
- Hacer clic en "Config" al lado de Apache
- Seleccionar "httpd.conf"
- Descomentar la línea: `Include conf/extra/httpd-ssl.conf`
- Descomentar: `LoadModule ssl_module modules/mod_ssl.so`

### 2. Configurar certificado SSL
- Ir a `C:\xampp\apache\conf\ssl.crt\`
- Generar certificado autofirmado o usar el existente

### 3. Modificar Virtual Host
Agregar en `C:\xampp\apache\conf\extra\httpd-ssl.conf`:

```apache
<VirtualHost *:443>
    DocumentRoot "C:/xampp/htdocs/TecnoAPK"
    ServerName tecnoapk.local
    SSLEngine on
    SSLCertificateFile "conf/ssl.crt/server.crt"
    SSLCertificateKeyFile "conf/ssl.key/server.key"
</VirtualHost>
```

### 4. Modificar hosts file
Agregar en `C:\Windows\System32\drivers\etc\hosts`:
```
127.0.0.1 tecnoapk.local
```

### 5. Acceder desde móvil
- Usar `https://tu-ip-local:443/TecnoAPK`
- Aceptar certificado no seguro en el navegador móvil