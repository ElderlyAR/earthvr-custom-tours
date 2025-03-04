@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="prose prose-indigo max-w-none">
                    <h1>Privacy Policy</h1>
                    
                    <p class="lead">
                        Last updated: March 4, 2025
                    </p>
                    
                    <p>
                        This Privacy Policy describes how Google Earth VR Custom Tour Generator ("we", "us", or "our") collects, uses, and discloses your information when you use our service.
                    </p>
                    
                    <h2>Information We Collect</h2>
                    
                    <h3>Information You Provide</h3>
                    
                    <p>
                        When you use our service, we may collect the following information:
                    </p>
                    
                    <ul>
                        <li><strong>JPG Files:</strong> We temporarily process the JPG files you upload to extract location metadata. These files are not permanently stored on our servers and are deleted after processing.</li>
                        <li><strong>Tour Settings:</strong> We process the tour settings you provide (delay time, time of day, tour name) to generate your custom tour file.</li>
                    </ul>
                    
                    <h3>Automatically Collected Information</h3>
                    
                    <p>
                        When you access our service, we may automatically collect certain information, including:
                    </p>
                    
                    <ul>
                        <li><strong>Usage Data:</strong> We may collect information on how you use our service, such as the features you use, the time and duration of your visit, and the pages you view.</li>
                        <li><strong>Device Information:</strong> We may collect information about your device, including your IP address, browser type, operating system, and device identifiers.</li>
                        <li><strong>Cookies and Similar Technologies:</strong> We may use cookies and similar tracking technologies to track activity on our service and hold certain information.</li>
                    </ul>
                    
                    <h2>How We Use Your Information</h2>
                    
                    <p>
                        We use the information we collect for various purposes, including:
                    </p>
                    
                    <ul>
                        <li>To provide and maintain our service</li>
                        <li>To generate custom tour files based on your uploaded JPG files and settings</li>
                        <li>To improve and optimize our service</li>
                        <li>To monitor the usage of our service</li>
                        <li>To detect, prevent, and address technical issues</li>
                    </ul>
                    
                    <h2>Third-Party Services</h2>
                    
                    <p>
                        We may use third-party services that collect, monitor, and analyze data to help us improve our service:
                    </p>
                    
                    <ul>
                        <li><strong>Google Maps API:</strong> We use the Google Maps Elevation API to retrieve elevation data for the locations in your tour. Your location data (latitude and longitude) is shared with Google for this purpose. Google's privacy policy can be found at <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer">https://policies.google.com/privacy</a>.</li>
                        <li><strong>Analytics:</strong> We may use analytics services to track and analyze usage of our service. These services may collect information sent by your browser or device, including the pages you visit and other information that assists us in improving our service.</li>
                    </ul>
                    
                    <h2>Data Retention</h2>
                    
                    <p>
                        We retain your information only for as long as necessary for the purposes set out in this Privacy Policy. We will retain and use your information to the extent necessary to comply with our legal obligations, resolve disputes, and enforce our policies.
                    </p>
                    
                    <p>
                        Your uploaded JPG files are processed immediately and are not permanently stored on our servers. They are automatically deleted after processing or within 24 hours, whichever comes first.
                    </p>
                    
                    <h2>Security</h2>
                    
                    <p>
                        The security of your data is important to us, but remember that no method of transmission over the Internet or method of electronic storage is 100% secure. While we strive to use commercially acceptable means to protect your personal information, we cannot guarantee its absolute security.
                    </p>
                    
                    <h2>Your Rights</h2>
                    
                    <p>
                        Depending on your location, you may have certain rights regarding your personal information, such as:
                    </p>
                    
                    <ul>
                        <li>The right to access the personal information we have about you</li>
                        <li>The right to request correction of inaccurate personal information</li>
                        <li>The right to request deletion of your personal information</li>
                        <li>The right to object to processing of your personal information</li>
                        <li>The right to data portability</li>
                        <li>The right to withdraw consent</li>
                    </ul>
                    
                    <p>
                        To exercise any of these rights, please contact us using the information provided in the "Contact Us" section below.
                    </p>
                    
                    <h2>Children's Privacy</h2>
                    
                    <p>
                        Our service is not intended for use by children under the age of 13. We do not knowingly collect personally identifiable information from children under 13. If you are a parent or guardian and you are aware that your child has provided us with personal information, please contact us so that we can take necessary actions.
                    </p>
                    
                    <h2>Changes to This Privacy Policy</h2>
                    
                    <p>
                        We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date at the top of this Privacy Policy.
                    </p>
                    
                    <p>
                        You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.
                    </p>
                    
                    <h2>Contact Us</h2>
                    
                    <p>
                        If you have any questions about this Privacy Policy, please contact us:
                    </p>
                    
                    <ul>
                        <li>By email: privacy@earthvr-custom-tours.app</li>
                        <li>By visiting the GitHub repository: <a href="https://github.com/thrnz/earthvr-custom-tours/issues" target="_blank" rel="noopener noreferrer">https://github.com/thrnz/earthvr-custom-tours/issues</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection