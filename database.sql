SELECT
    YEAR(e.datum) AS 'év',
    SUM(
        CASE
            WHEN e.deviza_id = 1 THEN e.ar * e.mennyiseg
            WHEN a.arfolyam IS NOT NULL THEN(e.ar * a.arfolyam) * e.mennyiseg
        	ELSE(e.ar * d.alap_arfolyam) * e.mennyiseg
        END
	) AS 'formagalom_HUF',
	SUM(
        CASE
        	WHEN e.deviza_id = 1 THEN IF(ae.arfolyam IS NOT NULL, (e.ar / ae.arfolyam) * e.mennyiseg, (e.ar / d.alap_arfolyam) * e.mennyiseg)
        	WHEN e.deviza_id = 2 THEN e.ar * e.mennyiseg
        	WHEN a.arfolyam IS NOT NULL AND ae.arfolyam IS NOT NULL THEN ((e.ar * a.arfolyam)/ ae.arfolyam) * e.mennyiseg
        	WHEN a.arfolyam IS NULL AND ae.arfolyam IS NOT NULL THEN ((e.ar * d.alap_arfolyam)/ ae.arfolyam) * e.mennyiseg
        	WHEN a.arfolyam IS NOT NULL AND ae.arfolyam IS NULL THEN ((e.ar * a.arfolyam)/ de.alap_arfolyam) * e.mennyiseg
        	WHEN a.arfolyam IS NULL AND ae.arfolyam IS NULL THEN ((e.ar * d.alap_arfolyam)/ de.alap_arfolyam) * e.mennyiseg
        END
    ) AS 'formaglom_EUR'
FROM
    `eladas` e
LEFT JOIN deviza d ON
    d.id = e.deviza_id
LEFT JOIN arfolyam a ON
    e.deviza_id = a.deviza_id AND a.ev = YEAR(e.datum) AND a.ho = MONTH(e.datum)
LEFT JOIN arfolyam ae ON
	ae.deviza_id = 2 AND a.ev = YEAR(e.datum) AND a.ho = MONTH(e.datum)
LEFT JOIN deviza de ON
	de.id = 2
WHERE
    1
GROUP BY
    1
