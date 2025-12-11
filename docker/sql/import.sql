-- Testdata voor User tabel
INSERT INTO `User` (`idUser`, `token`, `username`) VALUES
(1, 'token_user1_abc123def456', 'jasper'),
(2, 'token_user2_xyz789uvw012', 'maria'),
(3, 'token_user3_pqr345stu678', 'peter'),
(4, 'token_user4_mno901jkl234', 'anna');

-- Testdata voor Bericht tabel
INSERT INTO `Bericht` (`idbericht`, `bericht_inhoud`, `verzender`) VALUES
(1, 'Hallo Maria, dit is mijn eerste bericht. Alles goed met je?', 1),
(2, 'Hoi Jasper! Ja hoor, alles is goed. Hoe gaat het met jou?', 2),
(3, 'Peter hier. Ik heb een vraag over het project volgende week.', 3),
(4, 'Anna zegt: Kan iemand mij helpen met de deadline van donderdag?', 4),
(5, 'Jasper terug: Met mij gaat het prima! Bedankt dat je vraagt.', 1);

-- Testdata voor Ontvanger tabel (koppelt berichten aan ontvangers)
INSERT INTO `Ontvanger` (`Bericht_idbericht`, `User_idUser`) VALUES
(1, 2),
(2, 1),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(4, 3),
(5, 2);
