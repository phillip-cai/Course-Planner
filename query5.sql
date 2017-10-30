SELECT (a1.totalCount-a2.takenCount)/4 AS semestersLeft
FROM
	(SELECT SUM(classCount) as totalCount
	FROM (
		(SELECT COUNT(*) AS classCount
		FROM degree,hasReq
		WHERE degree.field = 'Computer Science'
		AND degree.majorminor = 'BA'
		AND degree.degID = hasReq.dID)
	UNION ALL
		(SELECT SUM(elecCount) AS classCount
		FROM hasElec JOIN degree ON hasElec.dID=degree.degID
		WHERE degree.field = 'Computer Science'
		AND degree.majorminor = 'BA')) totalCount) a1,
	(SELECT COUNT(*) as takenCount
	FROM course
	WHERE course.courseNum = 'CS 170'
	OR course.courseNum = 'CS 171'
	OR course.courseNum = 'Math 111'
	OR course.courseNum = 'Math 112'
	OR course.courseNum = 'Math 211') a2;