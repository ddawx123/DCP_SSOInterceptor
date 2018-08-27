<%
'///////////////////////////////////////////////////////////////////////////////
'// 插件应用:    1.9 其它版本的Z-blog未知
'// 插件制作:    David Ding(http://www.dingstudio.cn/)
'// 备    注:    DSSO - 挂口函数页
'///////////////////////////////////////////////////////////////////////////////

'*********************************************************
' 挂口: 注册插件和接口
'*********************************************************


'注册插件
Call RegisterPlugin("DSSO","ActivePlugin_DSSO")
'挂口部分
Function ActivePlugin_DSSO()
    Call Add_Action_Plugin("Action_Plugin_BlogVerify_Begin","Do_SSOPolicy")
    Call Add_Action_Plugin("Action_Plugin_Command_Begin","Do_SSOPolicy")
End Function

Function Do_SSOPolicy()
    Select Case Request.QueryString("act")
        Case "login"
            If BlogUser.Level > 4 Then
                If Request.QueryString("token") = "" Then
                    Response.Redirect "https://passport.dingstudio.cn/sso/login?returnUrl=" & Server.URLEncode("http://" & Request.ServerVariables    ("HTTP_HOST") & Request.ServerVariables("PATH_INFO") & "?" & Request.ServerVariables("QUERY_STRING"))
                    Response.End
                Else
                    Dim HttpClient
                    Set HttpClient = CreateObject("Microsoft.XMLHTTP")
                    HttpClient.Open "GET", "https://passport.dingstudio.cn/api?format=json&action=verify&token=" & Request.QueryString("token") &     "&reqtime=" & Server.URLEncode(now()) & "&txtReturn", False
                    HttpClient.Send
                    Do While HttpClient.readyState <> 4
                        DoEvents
                    Loop
                    If HttpClient.responseText = "Unauthorize" Then
                        Response.Write "Invaild token, please try again later."
                    Else
	                    Dim objRS,i,j
                        Set objRS=Server.CreateObject("ADODB.Recordset")
                        objRS.CursorType = adOpenKeyset
                        objRS.LockType = adLockReadOnly
                        objRS.ActiveConnection=objConn
                        objRS.Source="SELECT * FROM [blog_Member] WHERE [mem_Name] = '" & HttpClient.responseText & "'"
                        objRS.Open()
                        If objRS.RecordCount = 0 Then
                            Response.Write "User not registed."
                        Else
                            Response.Cookies("username") = vbsescape(HttpClient.responseText)
	                        Response.Cookies("username").Expires = DateAdd("y", 1, now)
	                        Response.Cookies("username").Path = "/"
                            Response.Cookies("password") = objRS("mem_Password")
	                        Response.Cookies("password").Expires = DateAdd("y", 1, now)
	                        Response.Cookies("password").Path = "/"
	                        Response.Redirect "http://" & Request.ServerVariables("HTTP_HOST") & "/zb_system/admin/admin.asp"
                        End If
                    End If
                    Response.End
                End If
            Else
                Response.Redirect "http://" & Request.ServerVariables("HTTP_HOST") & "/zb_system/admin/admin.asp"
                Response.End
            End If
        Case "logout"
            Call Logout()
            Response.Redirect "https://passport.dingstudio.cn/sso/login.php?action=dologout&url=" & Server.URLEncode("http://" & Request.ServerVariables("HTTP_HOST"))
        Case Else
            Response.Write "<!-- DingStudio SSO Policy Loaded -->"
    End Select
End Function

%>
