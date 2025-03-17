#!/bin/sh

echo "Starting SSH Tunnel..."

# Start the SSH tunnel
ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null -N -L 3307:127.0.0.1:3306 -i /home/sail/.ssh/id_ed25519 forge@178.62.244.134
