CREATE VIEW v_cobrosalquiler_cobranza AS
    SELECT 
        cobro.id,
        pago.id as id_pago,
        cobro.saldo,
        cobro.estado,
        pago.monto
    FROM 
        cobros_alquiler as cobro 
    INNER JOIN 
        cobranza as pago
    ON 
        cobro.id = pago.cobros_alquiler_id;