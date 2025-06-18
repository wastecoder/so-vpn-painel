#!/usr/bin/env python3

import os
import json
from datetime import datetime

def log(msg):
    with open("/opt/vpn-cert-generator/logs/exec.log", "a") as f:
        f.write(f"{datetime.now()} - {msg}\n")

def deletar_vpn_cert(username):
    zip_path = f"/var/www/html/storage/{username}_cert.zip"
    json_path = "/var/www/html/storage/registros.json"

    try:
        if os.path.exists(zip_path):
            os.remove(zip_path)
            log(f"Certificado {username} removido do storage.")
        else:
            log(f"Arquivo {zip_path} não encontrado.")

        # Remove entrada do JSON
        if os.path.exists(json_path):
            with open(json_path, 'r') as f:
                registros = json.load(f)

            registros = [r for r in registros if r['id'] != username]

            with open(json_path, 'w') as f:
                json.dump(registros, f, indent=4)

            log(f"Registro {username} removido do JSON.")
        else:
            log("Arquivo registros.json não encontrado.")

    except Exception as e:
        log(f"Erro ao excluir certificado {username}: {e}")

# Uso via terminal
if __name__ == "__main__":
    import sys
    if len(sys.argv) < 2:
        print("Uso: sudo python3 deletar_certificado.py <username>")
    else:
        deletar_vpn_cert(sys.argv[1])
