FORMAT: 1A

# API_LCRM

# AppHttpControllersApiAuthController

## Login to system [POST /login]


+ Request (application/json)
    + Body

            {
                "email": "foo@bar.com",
                "password": "bar"
            }

+ Response 200 (application/json)
    + Body

            {
                "token": "token",
                "user": {
                    "id": 4,
                    "first_name": "Teacher",
                    "last_name": "Doe",
                    "email": "teacher@sms.com",
                    "phone_number": "465465415",
                    "user_id": "1",
                    "user_avatar": "image.jpg",
                    "permissions": "{sales_team.read:true,sales_team.write:true,sales_team.delete:true,leads.read:true,leads.write:true,leads.delete:true,opportunities.read:true,opportunities.write:true,opportunities.delete:true,logged_calls.read:true,logged_calls.write:true,logged_calls.delete:true,meetings.read:true,meetings.write:true,meetings.delete:true,products.read:true,products.write:true,products.delete:true,quotations.read:true,quotations.write:true,quotations.delete:true,sales_orders.read:true,sales_orders.write:true,sales_orders.delete:true,invoices.read:true,invoices.write:true,invoices.delete:true,pricelists.read:true,pricelists.write:true,pricelists.delete:true,contracts.read:true,contracts.write:true,contracts.delete:true,staff.read:true,staff.write:true,staff.delete:true}",
                    "subscription_ends_at": "2015-12-07 09:49:19"
                },
                "role": "user"
            }

+ Response 401 (application/json)
    + Body

            {
                "error": "invalid_credentials"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "could_not_create_token"
            }

# User [/user]
User and staff endpoints, can be accessed only with role "user" or "staff"

## Get all calendar items [GET /user/calendar]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "salesteam": [
                    {
                        "id": 1,
                        "salesteam": "Name of team",
                        "target": "111",
                        "invoice_forecast": "1125",
                        "actual_invoice": "205"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all calls [GET /user/calls]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "calls": [
                    {
                        "id": 1,
                        "date": "2015-10-15",
                        "call_summary": "Call summary",
                        "company": "Company",
                        "user": "User"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get call item [GET /user/call]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "call_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "call": {
                    "id": 1,
                    "opportunity": "r dfgfdg dfg",
                    "stages": "New",
                    "customer_id": 1,
                    "expected_revenue": "sad asd ",
                    "probability": "0",
                    "email": "admin@gmail.com",
                    "phone": 787889,
                    "sales_person_id": 2,
                    "sales_team_id": 1,
                    "next_action": "21.12.2015.",
                    "next_action_title": "454545",
                    "expected_closing": "29.12.2015.",
                    "priority": "Low",
                    "tags": "1,3",
                    "lost_reason": "Too expensive",
                    "internal_notes": "ghkhjkhjk",
                    "assigned_partner_id": 1,
                    "user_id": 1,
                    "created_at": "2015-12-22 20:17:20",
                    "updated_at": "2015-12-22 20:19:11",
                    "deleted_at": null
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post call [POST /user/post_call]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "date": "2015-10-11",
                "call_summary": "call summary",
                "company_id": "1",
                "resp_staff_id": "12"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit call [POST /user/edit_call]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "call_id": "1",
                "date": "2015-10-11",
                "call_summary": "call summary",
                "company_id": "1",
                "resp_staff_id": "12"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete call [POST /user/delete_call]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "call_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all categories [GET /user/categories]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "category": [
                    {
                        "id": 1,
                        "name": "Category name"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get category item [GET /user/category]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "category_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "category": {
                    "id": 1,
                    "name": "Category",
                    "user_id": 1,
                    "created_at": "2015-12-23 16:58:25",
                    "updated_at": "2015-12-23 16:58:25",
                    "deleted_at": null
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post category [POST /user/post_category]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "name": "category name"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit category [POST /user/edit_category]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "category_id": "1",
                "name": "category name"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete category [POST /user/delete_category]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "call_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all companies [GET /user/companies]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "companies": [
                    {
                        "id": 1,
                        "name": "Name",
                        "customer": "customer name",
                        "phone": "634654165456"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get company item [POST /user/company]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "company_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "company": {
                    "id": 2,
                    "name": "dg dfg",
                    "email": "user@crm.com",
                    "password": "",
                    "lostpw": "",
                    "address": "fdgdfg",
                    "website": "gfdgfdg",
                    "phone": "45454",
                    "mobile": "45",
                    "fax": "4545",
                    "title": "",
                    "company_avatar": "",
                    "company_attachment": "",
                    "main_contact_person": 3,
                    "sales_team_id": 1,
                    "country_id": 1,
                    "state_id": 43,
                    "city_id": 5914,
                    "longitude": "63.30929400000002",
                    "latitude": "35.6403478",
                    "user_id": 1,
                    "created_at": "2015-12-26 07:10:25",
                    "updated_at": "2015-12-26 07:10:25",
                    "deleted_at": null
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post company [POST /user/post_company]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "name": "Company name",
                "email": "email@email.com"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit company [POST /user/edit_company]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "company_id": "1",
                "name": "Company name",
                "email": "email@email.com"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete company [POST /user/delete_company]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "company_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all contracts [GET /user/contracts]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "company": [
                    {
                        "id": 1,
                        "start_date": "2015-11-12",
                        "description": "Description",
                        "name": "Company name",
                        "user": "User name"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get contract item [GET /user/contract]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "contract_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "contract": {
                    "id": 1,
                    "start_date": "21.12.2015.",
                    "end_date": "23.12.2015.",
                    "description": "ffdgfdg",
                    "company_id": 1,
                    "resp_staff_id": 2,
                    "real_signed_contract": "",
                    "user_id": 1,
                    "created_at": "2015-12-22 20:27:37",
                    "updated_at": "2015-12-22 20:27:37",
                    "deleted_at": null
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post contract [POST /user/post_contract]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "start_date": "2015-11-11",
                "end_date": "2015-11-11",
                "description": "Description"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit contract [POST /user/edit_contract]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "company_id": "1",
                "name": "Company name",
                "email": "email@email.com"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete contract [POST /user/delete_contract]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "company_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all customers [GET /user/customers]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "customers": [
                    {
                        "id": 1,
                        "full_namae": "full namae",
                        "email": "email@email.com",
                        "created_at": "2015--11-11"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get customer item [GET /user/customer]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "customer_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "contract": {
                    "id": 1,
                    "user_id": 3,
                    "belong_user_id": 2,
                    "address": "",
                    "website": "",
                    "job_position": "",
                    "mobile": "5456",
                    "fax": "",
                    "title": "",
                    "company_avatar": "",
                    "company_id": 0,
                    "sales_team_id": 0,
                    "created_at": "2015-12-22 19:26:19",
                    "updated_at": "2015-12-28 19:07:58",
                    "deleted_at": null
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post customer [POST /user/post_customer]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "first_name": "first name",
                "last_name": "last name",
                "email": "email@email.com",
                "password": "password"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit customer [POST /user/edit_customer]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "customer_id": "1",
                "first_name": "first name",
                "last_name": "last name",
                "email": "email@email.com",
                "password": "password"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete customer [POST /user/delete_customer]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "customer_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all invoices [GET /user/invoices]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "invoices": [
                    {
                        "id": 1,
                        "invoice_number": "1465456",
                        "invoice_date": "2015-11-11",
                        "customer": "Customer Name",
                        "unpaid_amount": "15.2",
                        "status": "Status",
                        "due_date": "2015-11-11"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get invoice item [GET /user/invoice]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "invoice_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "invoice": {
                    "id": 1,
                    "order_id": 0,
                    "customer_id": 3,
                    "sales_person_id": "2",
                    "sales_team_id": 1,
                    "invoice_number": "I0001",
                    "invoice_date": "08.12.2015. 00:00",
                    "due_date": "24.12.2015. 00:00",
                    "payment_term": "10",
                    "status": "Open Invoice",
                    "total": 1221,
                    "tax_amount": 195.36,
                    "grand_total": 1416.36,
                    "discount": 10,
                    "final_price": 1216.36,
                    "unpaid_amount": 1173.06,
                    "user_id": 1,
                    "created_at": "2015-12-23 18:05:35",
                    "updated_at": "2015-12-28 19:21:48",
                    "deleted_at": null
                },
                "products": {
                    "product": "product",
                    "description": "description",
                    "quantity": 3,
                    "unit_price": 1.95,
                    "taxes": 1.55,
                    "subtotal": 195.36
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post invoice [POST /user/post_invoice]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "customer_id": "5",
                "invoice_date": "2015-11-11",
                "sales_person_id": "2",
                "status": "status",
                "total": "10.00",
                "tax_amount": "01.10",
                "grand_total": "11.10",
                "discount": 1.2,
                "final_price": 9.85,
                "invoice_prefix": "I00",
                "invoice_start_number": "0"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit invoice [POST /user/edit_invoice]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "invoice_id": "1",
                "customer_id": "5",
                "invoice_date": "2015-11-11",
                "sales_person_id": "2",
                "status": "status",
                "total": "10.00",
                "tax_total": "01.10",
                "grand_total": "11.10",
                "discount": "0.10",
                "final_price": "9.10"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete invoice [POST /user/delete_invoice]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "invoice_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all invoice_payment [GET /user/invoice]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "invoices": [
                    {
                        "id": 1,
                        "payment_number": "P002",
                        "payment_received": "1525.26",
                        "payment_method": "Paypal",
                        "payment_date": "2015-11-11",
                        "customer": "Customer Name",
                        "person": "Person Name"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all leads [GET /user/leads]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "leads": [
                    {
                        "id": 1,
                        "register_time": "2015-12-22",
                        "opportunity": "1.2",
                        "contact_name": "Contact name",
                        "email": "dsad@asd.com",
                        "phone": "456469465",
                        "salesteam": "Test team"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get lead item [GET /user/lead]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "lead_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "invoice": {
                    "id": 1,
                    "opportunity": "Lead",
                    "company_name": "sdfsdf sdf",
                    "customer_id": 1,
                    "address": "sd fsdfd",
                    "country_id": 1,
                    "state_id": 43,
                    "city_id": 5914,
                    "sales_person_id": 1,
                    "sales_team_id": 1,
                    "contact_name": "sdfsdf sdf sdf ",
                    "title": "Doctor",
                    "email": "user@crm.com",
                    "function": "asdasd sad asd ",
                    "phone": "1545",
                    "mobile": "545",
                    "fax": "1545",
                    "tags": "2,4",
                    "priority": "Low",
                    "internal_notes": "asd asd asd ",
                    "assigned_partner_id": 0,
                    "user_id": 1,
                    "created_at": "2015-12-22 19:56:54",
                    "updated_at": "2015-12-22 19:56:54",
                    "deleted_at": null
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post lead [POST /user/post_lead]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "opportunity": "125.5",
                "email": "test@test.com",
                "customer_id": "12",
                "sales_team_id": "1",
                "tags": "Softwae",
                "country_id": "15"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit lead [POST /user/edit_lead]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "lead_id": 1,
                "opportunity": "125.5",
                "email": "test@test.com",
                "customer_id": "12",
                "sales_team_id": "1",
                "tags": "Softwae",
                "country_id": "15"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete lead [POST /user/delete_lead]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "lead_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all lead call [GET /user/lead_call]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "lead_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "calls": [
                    {
                        "id": 1,
                        "date": "2015-10-15",
                        "call_summary": "Call summary",
                        "company": "Company",
                        "responsible": "User"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post lead call [POST /user/post_lead_call]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "lead_id": "1",
                "date": "2015-10-11",
                "call_summary": "call summary",
                "company_id": "1",
                "resp_staff_id": "12"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit lead call [POST /user/edit_lead_call]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "call_id": "1",
                "lead_id": "1",
                "date": "2015-10-11",
                "call_summary": "call summary",
                "company_id": "1",
                "resp_staff_id": "12"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete lead call [POST /user/delete_lead_call]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "call_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all meetings [GET /user/meetings]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "meetings": [
                    {
                        "id": 1,
                        "meeting_subject": "meeting subject",
                        "starting_date": "2015-12-22",
                        "ending_date": "2015-12-22",
                        "responsible": "User name"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get meeting item [GET /user/meeting]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "meeting_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "meeting": {
                    "id": 2,
                    "meeting_subject": "Meeting",
                    "attendees": "1",
                    "responsible_id": 2,
                    "starting_date": "29.12.2015. 00:00",
                    "ending_date": "08.01.2016. 00:00",
                    "all_day": 0,
                    "location": "sdfsdf",
                    "meeting_description": "ftyf hgfhgfh",
                    "privacy": "Everyone",
                    "show_time_as": "Free",
                    "duration": "",
                    "user_id": 0,
                    "created_at": "2015-12-22 20:19:42",
                    "updated_at": "2015-12-26 15:03:37",
                    "deleted_at": null
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post meeting [POST /user/post_meeting]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "meeting_subject": "Subject",
                "starting_date": "2015-11-11",
                "ending_date": "2015-11-11"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit meeting [POST /user/edit_meeting]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "meeting_id": 1,
                "meeting_subject": "Subject",
                "starting_date": "2015-11-11",
                "ending_date": "2015-11-11"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete meeting [POST /user/delete_meeting]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "meeting_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all opportunity call [GET /user/opportunity_call]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "opportunity_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "calls": [
                    {
                        "id": 1,
                        "date": "2015-10-15",
                        "call_summary": "Call summary",
                        "company": "Company",
                        "responsible": "User"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post opportunity call [POST /user/post_opportunity_call]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "opportunity_id": "1",
                "date": "2015-10-11",
                "call_summary": "call summary",
                "company_id": "1",
                "resp_staff_id": "12"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit opportunity call [POST /user/edit_opportunity_call]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "opportunity_id": "1",
                "lead_id": "1",
                "date": "2015-10-11",
                "call_summary": "call summary",
                "company_id": "1",
                "resp_staff_id": "12"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete opportunity call [POST /user/delete_opportunity_call]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "call_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all opportunities [GET /user/opportunities]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "opportunities": [
                    {
                        "id": 1,
                        "opportunity": "Opportunity",
                        "company": "Company",
                        "next_action": "2015-12-22",
                        "stages": "Stages",
                        "expected_revenue": "Expected revenue",
                        "probability": "probability",
                        "salesteam": "salesteam",
                        "calls": "5",
                        "meetings": "5"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get opportunity item [GET /user/opportunity]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "opportunity_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "opportunity": {
                    "id": 1,
                    "opportunity": "r dfgfdg dfg",
                    "stages": "New",
                    "customer_id": 1,
                    "expected_revenue": "sad asd ",
                    "probability": "0",
                    "email": "admin@gmail.com",
                    "phone": 787889,
                    "sales_person_id": 2,
                    "sales_team_id": 1,
                    "next_action": "21.12.2015.",
                    "next_action_title": "454545",
                    "expected_closing": "29.12.2015.",
                    "priority": "Low",
                    "tags": "1,3",
                    "lost_reason": "Too expensive",
                    "internal_notes": "ghkhjkhjk",
                    "assigned_partner_id": 1,
                    "user_id": 1,
                    "created_at": "2015-12-22 20:17:20",
                    "updated_at": "2015-12-22 20:19:11",
                    "deleted_at": null
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post opportunity [POST /user/post_opportunity]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "opportunity": "Opportunity",
                "email": "email@email.com",
                "customer": "1",
                "sales_team_id": "1",
                "next_action": "2015-11-11",
                "expected_closing": "2015-11-11"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit opportunity [POST /user/edit_opportunity]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "opportunity_id": 1,
                "opportunity": "Opportunity",
                "email": "email@email.com",
                "customer": "1",
                "sales_team_id": "1",
                "next_action": "2015-11-11",
                "expected_closing": "2015-11-11"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete opportunity [POST /user/delete_opportunity]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "opportunity_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all opportunity meeting [GET /user/opportunity_meeting]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "opportunity_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "salesteam": [
                    {
                        "id": 1,
                        "meeting_subject": "meeting subject",
                        "starting_date": "2015-12-22",
                        "ending_date": "2015-12-22",
                        "responsible": "User name"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post opportunity meeting [POST /user/post_opportunity_meeting]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "opportunity_id": 1,
                "meeting_subject": "Subject",
                "starting_date": "2015-11-11",
                "ending_date": "2015-11-11"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit opportunity meeting [POST /user/edit_opportunity_meeting]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "meeting_id": 1,
                "opportunity_id": 1,
                "meeting_subject": "Subject",
                "starting_date": "2015-11-11",
                "ending_date": "2015-11-11"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete opportunity meeting [POST /user/delete_opportunity_meeting]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "meeting_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all products [GET /user/products]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "products": [
                    {
                        "id": 1,
                        "product_name": "product name",
                        "name": "category",
                        "product_type": "Type",
                        "status": "1",
                        "quantity_on_hand": "12",
                        "quantity_available": "52"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get product item [GET /user/product]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "product_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "product": {
                    "id": 1,
                    "product_name": "product",
                    "product_image": "",
                    "category_id": 1,
                    "product_type": "Consumable",
                    "status": "In Development",
                    "quantity_on_hand": 12,
                    "quantity_available": 22,
                    "sale_price": 1,
                    "description": "sdfdsfsdf",
                    "description_for_quotations": "sdfsdfsdfsdf",
                    "user_id": 1,
                    "created_at": "2015-12-23 16:58:51",
                    "updated_at": "2015-12-26 07:24:51",
                    "deleted_at": null
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post product [POST /user/post_product]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "product_name": "product name",
                "sale_price": "15.2",
                "description": "sadsadsd",
                "quantity_on_hand": "12",
                "quantity_available": "11"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit product [POST /user/edit_product]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "product_id": "1",
                "product_name": "product name",
                "sale_price": "15.2",
                "description": "sadsadsd",
                "quantity_on_hand": "12",
                "quantity_available": "11"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete product [POST /user/delete_product]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "product_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all qtemplates [GET /user/qtemplates]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "qtemplates": [
                    {
                        "id": 1,
                        "quotation_template": "product name",
                        "quotation_duration": "10"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get qtemplate item [GET /user/qtemplate]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "qtemplate_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "qtemplate": {
                    "id": 1,
                    "quotation_template": "testaa",
                    "quotation_duration": 19,
                    "immediate_payment": 0,
                    "terms_and_conditions": "sd f sdf 22",
                    "total": 2553,
                    "tax_amount": 408.48,
                    "grand_total": 2961.48,
                    "user_id": 1,
                    "created_at": "2015-12-23 18:45:58",
                    "updated_at": "2015-12-23 18:46:21",
                    "deleted_at": null
                },
                "products": {
                    "product": "product",
                    "description": "description",
                    "quantity": 3,
                    "unit_price": 1.95,
                    "taxes": 1.55,
                    "subtotal": 195.36
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post qtemplate [POST /user/post_qtemplate]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "product_name": "product name",
                "sale_price": "15.2",
                "description": "sadsadsd",
                "quantity_on_hand": "12",
                "quantity_available": "11",
                "total": "10.00",
                "tax_amount": "1.11",
                "grand_total": "11.11"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit qtemplate [POST /user/edit_qtemplate]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "qtemplate_id": "1",
                "product_name": "product name",
                "sale_price": "15.2",
                "description": "sadsadsd",
                "quantity_on_hand": "12",
                "quantity_available": "11",
                "total": "10.00",
                "tax_amount": "1.11",
                "grand_total": "11.11"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete qtemplate [POST /user/delete_qtemplate]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "qtemplate_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all quotations [GET /user/quotations]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "quotations": [
                    {
                        "id": 1,
                        "quotations_number": "4545",
                        "date": "2015-11-11",
                        "customer": "customer name",
                        "person": "person name",
                        "final_price": "12",
                        "status": "1"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get quotation item [GET /user/quotation]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "quotation_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "quotation": {
                    "id": 1,
                    "quotations_number": "Q0001",
                    "customer_id": 3,
                    "qtemplate_id": 0,
                    "date": "08.12.2015. 00:00",
                    "exp_date": "30.12.2015.",
                    "payment_term": "10",
                    "sales_person_id": 2,
                    "sales_team_id": 1,
                    "terms_and_conditions": "dff dfg dfg",
                    "status": "Draft Quotation",
                    "total": 333,
                    "tax_amount": 53.28,
                    "grand_total": 386.28,
                    "discount": 11.28,
                    "final_price": 289.28,
                    "user_id": 1,
                    "created_at": "2015-12-23 18:39:12",
                    "updated_at": "2015-12-23 18:39:12",
                    "deleted_at": null
                },
                "products": {
                    "product": "product",
                    "description": "description",
                    "quantity": 3,
                    "unit_price": 1.95,
                    "taxes": 1.55,
                    "subtotal": 195.36
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post quotation [POST /user/post_quotation]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "customer_id": "1",
                "date": "2015-11-11",
                "qtemplate_id": "1",
                "payment_term": "term",
                "sales_person_id": "1",
                "sales_team_id": "1",
                "grand_total": "12.5",
                "discount": "10.2",
                "final_price": "10.25",
                "quotation_prefix": "Q00",
                "quotation_start_number": "0"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit quotation [POST /user/edit_quotation]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "quotation_id": "1",
                "customer_id": "1",
                "date": "2015-11-11",
                "qtemplate_id": "1",
                "payment_term": "term",
                "sales_person": "1",
                "sales_team_id": "1",
                "grand_total": "12.5",
                "discount": "10.2",
                "final_price": "10.25"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete quotation [POST /user/delete_quotation]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "quotation_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all sales orders [GET /user/sales_orders]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "salesorders": [
                    {
                        "id": 1,
                        "quotations_number": "product name",
                        "date": "2015-11-11",
                        "customer": "customer name",
                        "person": "sales person name",
                        "final_price": "12.53",
                        "status": "1"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get salesorder item [GET /user/salesorder]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "salesorder_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "salesorder": {
                    "id": 1,
                    "sale_number": "S0001",
                    "customer_id": 3,
                    "qtemplate_id": 0,
                    "date": "15.12.2015.",
                    "exp_date": "15.12.2015.",
                    "payment_term": "15",
                    "sales_person_id": 2,
                    "sales_team_id": 1,
                    "terms_and_conditions": "drtret",
                    "status": "Draft sales order",
                    "total": 1221,
                    "tax_amount": 195.36,
                    "grand_total": 1416.36,
                    "discount": 11.28,
                    "final_price": 289.28,
                    "user_id": 1,
                    "created_at": "2015-12-23 17:12:39",
                    "updated_at": "2015-12-23 17:12:39",
                    "deleted_at": null
                },
                "products": {
                    "product": "product",
                    "description": "description",
                    "quantity": 3,
                    "unit_price": 1.95,
                    "taxes": 1.55,
                    "subtotal": 195.36
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post Sales Order [POST /user/post_sales_order]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "customer_id": "1",
                "date": "2015-11-11",
                "qtemplate_id": "1",
                "payment_term": "term",
                "sales_person_id": "1",
                "sales_team_id": "1",
                "grand_total": "12.5",
                "discount": "10.2",
                "final_price": "10.25",
                "sales_prefix": "S00",
                "sales_start_number": "0"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit quotation [POST /user/edit_sales_order]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "sales_order_id": "1",
                "customer_id": "1",
                "date": "2015-11-11",
                "qtemplate_id": "1",
                "payment_term": "term",
                "sales_person_id": "1",
                "sales_team_id": "1",
                "grand_total": "12.5",
                "discount": "10.2",
                "final_price": "10.25"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete quotation [POST /user/delete_sales_order]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "sales_order_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all salesteams [GET /user/salesteams]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "salesteam": [
                    {
                        "id": 1,
                        "salesteam": "Name of team",
                        "target": "111",
                        "invoice_forecast": "1125",
                        "actual_invoice": "205"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get salesteam item [GET /user/salesteam]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "salesteam_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "salesteam": {
                    "id": 1,
                    "salesteam": "testera tim 1",
                    "team_leader": 2,
                    "quotations": false,
                    "leads": false,
                    "opportunities": false,
                    "invoice_target": 15,
                    "invoice_forecast": 22,
                    "actual_invoice": 0,
                    "notes": "dfg fdg dfg",
                    "user_id": 1,
                    "created_at": "2015-12-22 19:47:18",
                    "updated_at": "2015-12-22 19:47:29",
                    "deleted_at": null
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post salesteam [POST /user/post_salesteam]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "salesteam": "Title",
                "invoice_target": "8",
                "invoice_forecast": "1",
                "team_leader": "12",
                "team_members": "1,2,5"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit salesteam [POST /user/edit_salesteam]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "salesteam_id": "1",
                "salesteam": "Title",
                "invoice_target": "8",
                "invoice_forecast": "1",
                "team_leader": "12",
                "team_members": "1,2,5"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete salesteam [POST /user/delete_salesteam]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "salesteam_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all staff [GET /user/staff]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "staff": [
                    {
                        "id": 1,
                        "full_name": "product name",
                        "email": "email@email.com",
                        "created_at": "2015-11-11"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post staff [POST /user/post_staff]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "first_name": "first name",
                "last_name": "last name",
                "email": "email@email.com",
                "password": "1password"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit staff [POST /user/edit_staff]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "staff_id": "1",
                "first_name": "first name",
                "last_name": "last name",
                "password": "1password"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete staff [POST /user/delete_staff]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "staff_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

# Customer [/customer]
Customer endpoints, can be accessed only with role "customer"

## Get all contract [GET /customer/contract]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "company": [
                    {
                        "id": 1,
                        "start_date": "2015-11-12",
                        "end_date": "2015-11-15",
                        "description": "Description",
                        "company": "Company name",
                        "user": "User name"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all invoice [GET /customer/invoice]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "invoices": [
                    {
                        "id": 1,
                        "invoice_number": "I0056",
                        "invoice_date": "2015-11-11",
                        "customer": "Customer Name",
                        "due_date": "2015-11-12",
                        "grand_total": "15.2",
                        "unpaid_amount": "15.2",
                        "status": "Status"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all quotation [GET /customer/quotation]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "quotations": [
                    {
                        "id": 1,
                        "quotations_number": "Q002",
                        "date": "2015-11-11",
                        "customer": "customer name",
                        "person": "person name",
                        "grand_total": "12",
                        "status": "Draft quotation"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all sales order [GET /customer/sales_order]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "salesorder": [
                    {
                        "id": 1,
                        "sale_number": "S002",
                        "date": "2015-11-11",
                        "customer": "customer name",
                        "person": "sales person name",
                        "grand_total": "12.53",
                        "status": "Draft sales order"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }