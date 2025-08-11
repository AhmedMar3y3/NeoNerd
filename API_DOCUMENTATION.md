# API Documentation

## Authentication Endpoints

### 1. Register or Login
**POST** `/api/register-or-login`

Register a new user or login with existing phone number.

**Request Body:**
```json
{
    "phone": "201234567890"
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "phone": "201234567890",
            "is_verified": false
        },
        "message": "Verification code sent successfully"
    }
}
```

### 2. Verify Phone Number
**POST** `/api/verify-code`

Verify phone number with the received code.

**Request Body:**
```json
{
    "phone": "201234567890",
    "code": "123456"
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "phone": "201234567890",
            "is_verified": true,
            "profile_completed": false
        },
        "token": "1|abc123...",
        "message": "Phone verified successfully"
    }
}
```

### 3. Resend Verification Code
**POST** `/api/resend-code`

Resend verification code to the phone number.

**Request Body:**
```json
{
    "phone": "201234567890"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Verification code resent successfully"
}
```

### 4. Complete Profile
**POST** `/api/complete-profile`

Complete user profile with all academic information in one request.

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body (University Student):**
```json
{
    "first_name": "أحمد",
    "last_name": "محمد",
    "gender": "male",
    "academic_level": "university",
    "university_id": 1,
    "college_id": 1,
    "grade_id": 1,
    "image": "base64_encoded_image_or_file"
}
```

**Request Body (Secondary Student):**
```json
{
    "first_name": "فاطمة",
    "last_name": "علي",
    "gender": "female",
    "academic_level": "secondary",
    "secondary_type_id": 1,
    "secondary_grade": "first",
    "secondary_section": "scientific",
    "scientific_branch": "science",
    "image": "base64_encoded_image_or_file"
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "first_name": "أحمد",
            "last_name": "محمد",
            "phone": "201234567890",
            "gender": "male",
            "academic_level": "university",
            "university": {
                "id": 1,
                "name": "جامعة القاهرة"
            },
            "college": {
                "id": 1,
                "name": "كلية الحاسبات والمعلومات"
            },
            "grade": {
                "id": 1,
                "name": "السنة الأولى",
                "level": 1
            },
            "profile_completed": true
        },
        "message": "Profile completed successfully"
    }
}
```

### 5. Get User Profile
**GET** `/api/profile`

Get authenticated user's profile with academic details.

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "first_name": "أحمد",
            "last_name": "محمد",
            "phone": "201234567890",
            "gender": "male",
            "academic_level": "university",
            "university": {
                "id": 1,
                "name": "جامعة القاهرة"
            },
            "college": {
                "id": 1,
                "name": "كلية الحاسبات والمعلومات"
            },
            "grade": {
                "id": 1,
                "name": "السنة الأولى",
                "level": 1
            },
            "profile_completed": true
        }
    }
}
```

### 6. Logout
**POST** `/api/logout`

Logout user and invalidate token.

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "message": "Logged out successfully"
}
```

## Academic Data Endpoints

### 7. Get All Academic Data
**GET** `/api/academic-data`

Get all academic data for initialization (universities, secondary types, grades, etc.).

**Response:**
```json
{
    "success": true,
    "data": {
        "universities": [...],
        "secondary_types": [...],
        "secondary_grades": [...],
        "secondary_sections": [...],
        "scientific_branches": [...]
    }
}
```

### 8. Get Universities
**GET** `/api/universities`

Get all universities.

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "جامعة القاهرة"
        }
    ]
}
```

### 9. Get Colleges by University
**GET** `/api/colleges?university_id=1`

Get colleges for a specific university.

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "كلية الحاسبات والمعلومات",
            "university_id": 1
        }
    ]
}
```

### 10. Get Grades by College
**GET** `/api/grades?college_id=1`

Get grades for a specific college.

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "السنة الأولى",
            "level": 1,
            "college_id": 1
        }
    ]
}
```

### 11. Get Secondary Types
**GET** `/api/secondary-types`

Get secondary school types (arabic/language).

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "arabic",
            "description": "المدارس الثانوية العربية"
        },
        {
            "id": 2,
            "name": "language",
            "description": "المدارس الثانوية اللغات"
        }
    ]
}
```

### 12. Get Secondary Grades
**GET** `/api/secondary-grades`

Get available secondary grades.

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "value": "first",
            "label": "الصف الأول الثانوي"
        },
        {
            "value": "second",
            "label": "الصف الثاني الثانوي"
        },
        {
            "value": "third",
            "label": "الصف الثالث الثانوي"
        }
    ]
}
```

### 13. Get Secondary Sections
**GET** `/api/secondary-sections`

Get available secondary sections.

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "value": "literal",
            "label": "أدبي"
        },
        {
            "value": "scientific",
            "label": "علمي"
        }
    ]
}
```

### 14. Get Scientific Branches
**GET** `/api/scientific-branches`

Get available scientific branches.

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "value": "science",
            "label": "علوم"
        },
        {
            "value": "math",
            "label": "رياضيات"
        }
    ]
}
```

## Subject Endpoints

### 15. Get Subjects by Academic Level
**GET** `/api/subjects/academic-level?academic_level=university`

Get all subjects for a specific academic level.

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "برمجة الحاسوب",
            "description": "مادة برمجة الحاسوب للسنة 1",
            "academic_level": "university",
            "college_type_id": 1,
            "grade_level": 1
        }
    ]
}
```

### 16. Get Subjects by College and Grade
**GET** `/api/subjects/college-grade?college_id=1&grade_level=1`

Get subjects for a specific college and grade level.

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "برمجة الحاسوب",
            "description": "مادة برمجة الحاسوب للسنة 1 في كلية الحاسبات والمعلومات",
            "academic_level": "university",
            "college_type_id": 1,
            "grade_level": 1
        }
    ]
}
```

### 17. Get Subjects by Secondary Type
**GET** `/api/subjects/secondary-type?secondary_type_id=1&grade=first&section=scientific`

Get subjects for a specific secondary type, grade and section.

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "الرياضيات",
            "description": "مادة الرياضيات للصف الأول الثانوي - علمي - arabic",
            "academic_level": "secondary",
            "type": "scientific",
            "secondary_type_id": 1,
            "secondary_grade": "first",
            "secondary_section": "scientific"
        }
    ]
}
```

### 18. Get Subjects by Secondary Grade (Legacy)
**GET** `/api/subjects/secondary-grade?grade=first&section=scientific`

Get subjects for a specific secondary grade and section.

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "الرياضيات",
            "description": "مادة الرياضيات للصف الأول الثانوي",
            "academic_level": "secondary",
            "type": "scientific",
            "secondary_grade": "first",
            "secondary_section": "scientific"
        }
    ]
}
```

### 19. Get User Subjects
**GET** `/api/subjects/user`

Get subjects for the authenticated user based on their academic profile.

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "برمجة الحاسوب",
            "description": "مادة برمجة الحاسوب للسنة 1 في كلية الحاسبات والمعلومات",
            "academic_level": "university",
            "college_type_id": 1,
            "grade_level": 1
        }
    ]
}
```

## Subject System and Future Courses Integration

The subject system is designed to support the future courses feature efficiently:

### University Subjects Structure:
- **College Types**: Subjects are linked to college types (e.g., "Computer Science", "Medicine")
- **Cross-University Compatibility**: All Computer Science colleges share the same subjects regardless of university
- **Grade Levels**: Subjects are organized by grade level (1-6) within each college type

### Secondary Subjects Structure:
- **Secondary Types**: Subjects are linked to secondary types (arabic/language)
- **Grade and Section**: Subjects are organized by grade (first/second/third) and section (literal/scientific)
- **Subject Types**: Subjects can be scientific, literal, or both (common subjects)

### Benefits for Future Courses:
1. **No Duplication**: Same subjects for same college type across universities
2. **Efficient Storage**: One subject record serves multiple universities
3. **Easy Management**: Add subjects once per college type
4. **Scalable**: Easy to add new universities without duplicating subjects

### Example Usage:
- **Cairo University CS 1st year** and **Alexandria University CS 1st year** both get subjects from **College Type: "Computer Science" + Grade Level: 1**
- **Same subjects, no duplication, perfect for LMS!**

When the courses feature is implemented, each course will link to a subject, and users will see courses based on their college type and grade level, ensuring cross-university compatibility.
