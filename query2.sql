SELECT course.courseNum
FROM course,hasPrereq
WHERE hasPrereq.num = 'MATH 347'
AND hasPrereq.pNum = course.courseNum
ORDER BY course.courseNum;