
public class CoursesEditActivity extends AppCompatActivity {
	
	private text class;
				private text course_name;
				private text course_detail;
				private text course_fee;
				private EditText is_subject;
				private Button btn_update_courses;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_edit_courses);
		
		class = (text)findViewById(R.id.class);
				course_name = (text)findViewById(R.id.course_name);
				course_detail = (text)findViewById(R.id.course_detail);
				course_fee = (text)findViewById(R.id.course_fee);
				is_subject = (EditText)findViewById(R.id.is_subject);
				btn_edit_courses = (Button)findViewById(R.id.btn_update_courses);
		
		
		
		Intent intent = getIntent();
		String id = intent.getStringExtra("id");
		
		RequestQueue request_queue = Volley.newRequestQueue(CoursesEditActivity.this);
		StringRequest request = new StringRequest(Request.Method.POST, SERVER_URL+"/mobile/courses/view_courses/"+id, new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								try {
                    			JSONArray JsonArray = new JSONArray(server_response);
								for(int i=0; i<=JsonArray.length(); i++){
									JSONObject json_object = JsonArray.getJSONObject(i);
									class.setText(json_object.getString("class"));
				course_name.setText(json_object.getString("course_name"));
				course_detail.setText(json_object.getString("course_detail"));
				course_fee.setText(json_object.getString("course_fee"));
				is_subject.setText(json_object.getString("is_subject"));
				
			
								}
			
			
							} catch (JSONException e) {
								e.printStackTrace();
							 //   Toast.makeText(MainActivity.this, "error", Toast.LENGTH_SHORT).show();
							}
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(CoursesAddActivity.this, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									return params;
								}
							};
							
				 request_queue.add(request);



	
btn_update_courses.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
              final String form_class = class.getText().toString();
				final String form_course_name = course_name.getText().toString();
				final String form_course_detail = course_detail.getText().toString();
				final String form_course_fee = course_fee.getText().toString();
				final String form_is_subject = is_subject.getText().toString();
				
				
				RequestQueue request_queue = Volley.newRequestQueue(CoursesAddActivity.this); 
				 StringRequest request = new StringRequest(Request.Method.POST, url+"/mobile/courses/save_data/"+form_course_id, new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								Toast.makeText(CoursesAddActivity.this, server_response, Toast.LENGTH_SHORT).show();
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(CoursesAddActivity.this, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									params.put("class", form_class);
				params.put("course_name", form_course_name);
				params.put("course_detail", form_course_detail);
				params.put("course_fee", form_course_fee);
				params.put("is_subject", form_is_subject);
				
									return params;
								}
							};
							
				 request_queue.add(request);
				
				
            }
        });
//end here .....
		
		
        
    }

}
