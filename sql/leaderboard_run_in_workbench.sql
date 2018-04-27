use yecdata;
                 
SELECT ID, NickName, Score
FROM (
	SELECT ID,
		NickName,
		Score
	FROM (
		   SELECT  su.ID,
				   su.NickName,
				   SUM(a.Points) AS Score
			FROM School s
			   JOIN (
				 SELECT ID, NickName, SchoolID
				 FROM User u
				 WHERE u.SchoolID IN (
					  SELECT SchoolID
					  FROM User
					  WHERE ID=101
				 )
				) AS su ON su.SchoolID=s.ID
				JOIN Accomplishment ac ON ac.UserID=su.ID
				JOIN Action a ON ac.ActionID=a.ID
				GROUP BY su.ID, su.NickName
				ORDER BY Score DESC
	) AS tt1
) AS tt2;
