# YATA
Here is my technical solution to collect and display travel paths for Yet Another Travel Agency.
This minimalistically designed application comes with two core - and only - features:
 - It allows a user to load a travel path into the database by filling it in a form - or through a POST request under the name "json".
 - It displays the already stored paths one step at a time.

A SQL dump of an empty base is also included to help installing it elsewhere.

In case a reference frame would prove to be needed, it took around two hours and a half to build.
I tried indeed my best to reach the two hours goal that I was aiming for, and failed, even though I allowed myself to cut some corners in various ways:
 - I interpreted the part of the specifications regarding the design quite more liberally that I would have prefered
 - I removed the dynamic form that I had started to build to allow users to add travels in a more humane way because I was worried it would cost me too much time to finish it while also debugging the classes. Otherwise, I would have prefered to compliment - or even replace - the json option with another form with a field dedicated to each property of a travel step - with 'gate' and 'baggage_drop' only accessible with the 'type' field set to 'plane' - and a button appending an empty duplicate of this set of field when clicked on. The Travel constructor already handles both json and array entries anyway since that is how the SQL collection create new instances. I'm not very happy with this ambiguous entry type for this constructor, by the way, but PHP lacks an overload feature and it seemed clumsier to me in that context to implement a Factory than to allow multiple types. I remain open to discussion in that regard.
 - The Travel class also buggers me for some reason. I would have made it more modular in an actual use case, but given the restricted scope of this project and the lack of much things to make more modular in the first place, it would have looked like overkill while making the code less readable. I still separated the travel instances from their steps in the database and included a timestamp in the travels out of habit, because these things come in handy when it is far too late to put them in place if it wasn't already the case.
 - In a more general note, I have taken the decision to focus on the thick part of the code rather than the exposed bits - leading to a lacking interface - because I hold the belief that while an interface can be enriched and polished later, an application built on a lacky or shaking base can hardly be bettered without requiring some heavy work behind the curtains. This is probably debatable, but I chose to stand by it on this one.
