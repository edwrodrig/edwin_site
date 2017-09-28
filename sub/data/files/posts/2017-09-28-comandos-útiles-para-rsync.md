{
    "title": {
        "es": "Comandos \u00fatiles para Rsync"
    },
    "description": {
        "es": "Comandos \u00fatiles para Rsync"
    },
    "date": "2017-09-28",
    "tags": []
}
---
<h2>Copiar de una carpeta a otra</h2>
<pre>
rsync -rLptgoDvz -e "ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null" --progress <b>source</b> <b>target</b>
</pre>
<p>Notar que el argumento de la opción <code>-e</code> evita que <code>rsync</code> se detenga para preguntar si el servidor de destino es uno conocido</p>

<h2>Copiar pero basandose en checksums en vez de fecha</h2>
<pre>
rsync -rLptgoDvz -c -e "ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null" --progress <b>source</b> <b>target</b>
</pre>
<p>La magia la da el argumento <code>-c</code></p>
