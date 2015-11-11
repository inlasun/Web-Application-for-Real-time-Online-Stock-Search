import java.io.*;
import javax.servlet.*;
import javax.servlet.http.*;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import java.net.*;
import java.lang.*;
import net.sf.json.JSON;
import net.sf.json.JSONObject;
import net.sf.json.xml.XMLSerializer;//string

public class jservlet extends HttpServlet{

public void doGet(HttpServletRequest req,HttpServletResponse res)throws ServletException,IOException,MalformedURLException
{
  String index=req.getParameter("symbol");
  StringBuffer buffer = new StringBuffer();
  String urlString="http://default-environment-pbairmzse2.elasticbeanstalk.com/?symbol="+index;//
  URL url=new URL(urlString);
  URLConnection urlConnection= url.openConnection();
  urlConnection.setAllowUserInteraction(false);
  InputStream urlStream=url.openStream();//shorthand of  openConnection().getInputStream();
  urlConnection.setDoOutput(true);
  InputStreamReader isr=new InputStreamReader(urlStream);
  BufferedReader reader=new BufferedReader(isr);

  String l=null;
  String str=new String();
  while ((l= reader.readLine()) != null) 
 {
   str+=l;
 //buffer.append(str);
  }
   reader.close();

  XMLSerializer xml = new XMLSerializer();                                                                  
  JSON json = xml.read(str);  
  PrintWriter out =res.getWriter();
  out.println(json.toString(2));
}


public void doPost(HttpServletRequest request, HttpServletResponse response)  
            throws IOException, ServletException {  
        this.doGet(request, response);  
    }
}