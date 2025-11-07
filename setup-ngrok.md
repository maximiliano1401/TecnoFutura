# Usar ngrok para testing PWA con HTTPS

## Instalación y uso de ngrok:

### 1. Descargar ngrok
- Ir a https://ngrok.com/
- Crear cuenta gratuita
- Descargar ngrok.exe

### 2. Configurar ngrok
```bash
# Autenticar (obtener authtoken de tu cuenta)
ngrok authtoken tu_authtoken_aqui

# Exponer XAMPP con HTTPS
ngrok http 80
```

### 3. Resultado
ngrok te dará una URL como:
- HTTP: http://abc123.ngrok.io
- HTTPS: https://abc123.ngrok.io

### 4. Testing PWA
- Usar la URL HTTPS en tu móvil
- El botón de instalación aparecerá correctamente
- Funcionará como PWA real

### 5. Comando completo para TecnoAPK
```bash
# Desde donde tengas ngrok.exe
ngrok http 80 --subdomain=tecnoapk  # Si tienes plan paid para subdomain personalizado
# O simplemente:
ngrok http 80
```