CREATE VIEW v_cobrosalquiler_propiedades AS 
    SELECT 
        ca.id,
        ca.propiedades_id,
        ca.moneda_id,
        ca.fecha, 
        ca.monto, 
        ca.referencia, 
        ca.obs, 
        ca.fe_vto,
        ca.estado,
        ca.saldo, 
        p.id_remax
    FROM 
        cobros_alquiler as ca 
    INNER JOIN 
        propiedades as p 
    ON 
        p.id = ca.propiedades_id;