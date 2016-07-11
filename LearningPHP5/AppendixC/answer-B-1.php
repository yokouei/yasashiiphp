The regular expression ^\(?\d{3}\)?[- \.]\d{3}[- \.]\d{4}$ matches "an optional literal (, then three digits, then an optional literal ), then either a hyphen, space, or period, then three digits, then either a hyphen, space, or period, then four digits." The ^ and $ anchors make the expression match only phone numbers, not larger strings that contain phone numbers.