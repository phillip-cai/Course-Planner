SELECT SUM(classCount)
FROM (
	(SELECT COUNT(*) AS classCount
	FROM degree,hasReq
	WHERE degree.field = 'Applied Mathematics'
	AND degree.majorminor = 'BS'
	AND degree.degID = hasReq.dID)
UNION ALL
	(SELECT SUM(elecCount) AS classCount
	FROM hasElec JOIN degree ON hasElec.dID=degree.degID
	WHERE degree.field = 'Applied Mathematics'
	AND degree.majorminor = 'BS')) totalCount;