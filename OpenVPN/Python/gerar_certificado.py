#!/usr/bin/env python3

import subprocess
import os
import zipfile
from datetime import datetime

def log(msg):
    with open("/opt/vpn-cert-generator/logs/exec.log", "a") as f:
        f.write(f"{datetime.now()} - {msg}\n")

def generate_vpn_cert(username, zip_password=None):
    output_dir = "/var/www/html/storage"
    os.makedirs(output_dir, exist_ok=True)

    key_file = f"{output_dir}/{username}.key"
    crt_file = f"{output_dir}/{username}.crt"
    pem_file = f"{output_dir}/{username}.pem"
    zip_file = f"{output_dir}/{username}_cert.zip"

    try:
        subprocess.run(["openssl", "genrsa", "-out", key_file, "2048"], check=True)
        subprocess.run(["openssl", "req", "-new", "-x509", "-key", key_file, "-out", crt_file, "-days", "7",
                        "-subj", f"/CN={username}"], check=True)

        with open(pem_file, 'w') as f:
            f.write(open(key_file).read())
            f.write(open(crt_file).read())

        if zip_password:
            encrypted_zip = f"{output_dir}/{username}_cert_protected.zip"
            subprocess.run(["zip", "-P", zip_password, encrypted_zip, key_file, crt_file, pem_file],
                           cwd=output_dir, check=True)
            os.remove(zip_file)
            log(f"Certificado gerado com senha: {encrypted_zip}")
            print(f"Arquivo protegido gerado: {encrypted_zip}")
        else:
            with zipfile.ZipFile(zip_file, 'w', zipfile.ZIP_DEFLATED) as zipf:
                zipf.write(key_file, arcname=os.path.basename(key_file))
                zipf.write(crt_file, arcname=os.path.basename(crt_file))
                zipf.write(pem_file, arcname=os.path.basename(pem_file))
            log(f"Certificado gerado sem senha: {zip_file}")
            print(f"Arquivo gerado: {zip_file}")

        os.remove(key_file)
        os.remove(crt_file)
        os.remove(pem_file)

    except subprocess.CalledProcessError as e:
        log(f"Erro: {e}")
        print("Erro ao gerar certificado. Veja logs.")

# Exemplo de uso
if __name__ == "__main__":
    import sys
    if len(sys.argv) < 2:
        print("Uso: sudo python3 gerar_certificado.py <username> [senha_zip]")
    elif len(sys.argv) == 3:
        generate_vpn_cert(sys.argv[1], sys.argv[2])
    else:
        generate_vpn_cert(sys.argv[1])
