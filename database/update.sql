ALTER TABLE TU_TABLA
ADD COLUMN nombre_destinatario VARCHAR(255) AFTER id_usuario,
ADD COLUMN direccion_envio VARCHAR(255) AFTER nombre_destinatario,
ADD COLUMN cp VARCHAR(10) AFTER direccion_envio,
ADD COLUMN ciudad VARCHAR(100) AFTER cp,
ADD COLUMN telefono_contacto VARCHAR(20) AFTER ciudad;