CREATE VIEW v_asuntos_tickets AS
	SELECT 
        t.id,
        t.asuntos_id,
        t.usuario_id,
        t.fecha,
        t.explica,
        t.tipo,
        t.criticidad,
        t.estado,
        t.creador,
        t.fecreacion,
        t.solicitante,
        t.solic_mail,
        t.fec_cierre,
        t.solucion,
        a.asunto, 
        a.obs as asuntos_obs
     FROM 
        ticket as t 
     INNER JOIN 
        asuntos as a 
     ON 
        t.asuntos_id = a.id;