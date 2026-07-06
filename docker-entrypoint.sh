#!/bin/bash

# Forcefully disable any other MPMs and enable only prefork at runtime
a2dismod mpm_event 2>/dev/null || true
a2dismod mpm_worker 2>/dev/null || true
a2enmod mpm_prefork 2>/dev/null || true

# Start Apache
exec apache2-foreground