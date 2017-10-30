SELECT course.courseNum
FROM degree,course
WHERE degree.field = 'Computer Science'
AND degree.majorminor = 'BA'
AND (course.courseNum IN
	(SELECT hasReq.cNum
	FROM hasReq
	WHERE degree.degID = hasReq.dID)
OR course.courseNum IN
	(SELECT elecBucket.cNum
	FROM hasElec,elecBucket
	WHERE degree.degID = hasElec.dID
	AND hasElec.elecID = elecBucket.elecID))
ORDER BY course.courseNum;
